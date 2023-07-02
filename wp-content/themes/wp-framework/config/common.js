const path = require('path');
const webpack = require('webpack');
const local = require('./local');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');

const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
// include the css extraction and minification plugins
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

const CreateFileWebpack = require('create-file-webpack');

const __root = path.resolve(__dirname, '../');

module.exports = {
	entry: {
		app: ['@babel/polyfill', './src/scripts/index.js', './src/scss/app.scss'],
		admin: ['./src/scripts/admin.js', './src/scss/admin.scss'],
		// metabox: ['./src/scripts/metabox.js', './src/scss/metabox.scss'],
	},
	output: {
		path: path.resolve(__root, '../shady-theme/assets'),
		filename: 'scripts/[name].min.js',
		chunkFilename: 'scripts/[name].min.js',
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: ['@babel/preset-env'],
						plugins: ['@babel/plugin-syntax-dynamic-import']
					}
				},
				exclude: /node_modules/
			},
			// compile all .scss files to plain old css
			{
				test: /\.(sass|scss)$/,
				use: [
					MiniCssExtractPlugin.loader,
					{ loader: 'css-loader', options: { url: false, sourceMap: true } },
					{ loader: 'resolve-url-loader', options: { debug: true } },
					{ loader: 'sass-loader', options: { sourceMap: true } }, 
				]
			},
			{
				test: /\.css$/,
					use: ['style-loader', 'css-loader'],
			},
			{
				test: /\.(jpe?g|png|gif|svg)$/i,
				use: 'file-loader'
			},
			{
				test: /\.(woff|woff2|eot|ttf|otf)$/,
				use: 'file-loader'
			}
		]
	},
	plugins: [
		new webpack.HotModuleReplacementPlugin({
			title: 'Hot Module Replacement',
		}),
		new CleanWebpackPlugin(
			['shady-theme'],
			{ 
				root: path.resolve(__dirname, '../../'),
				verbose: true
			}
		),
		new CopyWebpackPlugin([
			{
				from: path.resolve(__root, 'static'),
				to: path.resolve(__root, '../shady-theme'),
			}
		]),
		// extract css into dedicated file
		new MiniCssExtractPlugin({
			filename: './css/[name].min.css'
		}),
		new BrowserSyncPlugin({
			host: local.host,
			port: 81,
			proxy: local.proxy,
			notify: true,
			reloadOnRestart: false,
			open: 'external',
			files: ['../shady-theme/assets/**/*.css', '../shady-theme/**/*.php'],
			cors: true,
			ui: false
		}, {
			reload: false,
			injectCss: true
		}),
		new webpack.ProvidePlugin({
			$: 'jquery',
			jQuery: 'jquery',
		}),
		new CreateFileWebpack({
			path: '../shady-theme',
			fileName: 'style.css',
			content: local.wpStyle
		})
	]
};
