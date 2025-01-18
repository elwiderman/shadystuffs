<?php

namespace GoDaddy\WordPress\MWC\Core\Features\Commerce\Catalog\Webhooks\Handlers;

use GoDaddy\WordPress\MWC\Core\Features\Commerce\Catalog\Interceptors\Handlers\ListRemoteVariantsJobHandler;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Catalog\Providers\DataObjects\ProductBase;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Catalog\Services\InsertLocalProductService;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Exceptions\Contracts\CommerceExceptionContract;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Repositories\ProductMapRepository;
use GoDaddy\WordPress\MWC\Core\Webhooks\DataObjects\Webhook;
use GoDaddy\WordPress\MWC\Core\Webhooks\Exceptions\WebhookProcessingException;
use GoDaddy\WordPress\MWC\Core\Webhooks\Repositories\WebhooksRepository;

/**
 * Handles `commerce.product.created` webhooks.
 */
class ProductCreatedWebhookHandler extends AbstractProductWebhookHandler
{
    /** @var InsertLocalProductService */
    protected InsertLocalProductService $insertLocalProductService;

    public function __construct(ProductMapRepository $productMapRepository, WebhooksRepository $webhooksRepository, InsertLocalProductService $insertLocalProductService)
    {
        $this->insertLocalProductService = $insertLocalProductService;

        parent::__construct($productMapRepository, $webhooksRepository);
    }

    /**
     * {@inheritDoc}
     *
     * @throws WebhookProcessingException
     *
     * @phpstan-assert-if-true null $this->localId
     */
    public function shouldHandle(Webhook $webhook) : bool
    {
        if ($this->localId = $this->getLocalId($webhook)) {
            // product already exists
            return false;
        }

        return parent::shouldHandle($webhook);
    }

    /**
     * {@inheritDoc}
     *
     * @throws WebhookProcessingException
     */
    public function handle(Webhook $webhook) : void
    {
        if (! $this->shouldHandle($webhook)) {
            return;
        }

        $productBase = $this->getProductBase($webhook);

        // This is a child product.
        if ($productBase->parentId) {
            return;
        }

        try {
            $this->insertLocalProductService->insert($productBase);
        } catch (CommerceExceptionContract $e) {
            throw new WebhookProcessingException('Failed to insert remote product: '.$webhook->remoteResourceId);
        }

        $this->maybeCreateVariantProduct($productBase);
    }

    /**
     * Maybe create a variant product.
     *
     * If the parent product already exists, we can create it.
     */
    protected function maybeCreateVariantProduct(ProductBase $productBase) : void
    {
        if (! $productBase->variants) {
            return;
        }

        ListRemoteVariantsJobHandler::scheduleListVariantsJob(
            ListRemoteVariantsJobHandler::getChunkedIds($productBase->variants)
        );
    }
}
