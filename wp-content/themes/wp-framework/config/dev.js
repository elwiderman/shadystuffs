const path = require('path');
const merge = require('webpack-merge');
const common = require('./common.js');
const local = require('./local');

module.exports = merge(common, {
	mode: 'development',
	devtool: 'cheap-eval-source-map',
	output: {
		publicPath: '/wp-content/themes/jtlb-theme/assets/',
	},
	devServer: {
		host: local.host,
		port: 8080,
		contentBase: path.join(__dirname, '../'),
		liveReload: true,
		// watchContentBase: true,
		// inline: true,
		writeToDisk: true,
		hot: true,
		// hotOnly: true,
		headers: {
			'Access-Control-Allow-Origin': '*',
		}
	}
});
