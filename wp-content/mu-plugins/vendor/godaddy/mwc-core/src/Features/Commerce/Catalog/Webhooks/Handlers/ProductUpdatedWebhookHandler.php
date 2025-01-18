<?php

namespace GoDaddy\WordPress\MWC\Core\Features\Commerce\Catalog\Webhooks\Handlers;

use GoDaddy\WordPress\MWC\Core\Features\Commerce\Catalog\Interceptors\Handlers\ListRemoteVariantsJobHandler;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Catalog\Providers\DataObjects\ProductBase;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Catalog\Services\UpdateLocalProductService;
use GoDaddy\WordPress\MWC\Core\Features\Commerce\Repositories\ProductMapRepository;
use GoDaddy\WordPress\MWC\Core\Webhooks\DataObjects\Webhook;
use GoDaddy\WordPress\MWC\Core\Webhooks\Exceptions\WebhookProcessingException;
use GoDaddy\WordPress\MWC\Core\Webhooks\Repositories\WebhooksRepository;

/**
 * Handles `commerce.product.updated` webhooks.
 */
class ProductUpdatedWebhookHandler extends AbstractProductWebhookHandler
{
    protected ProductMapRepository $productMapRepository;
    protected UpdateLocalProductService $updateLocalProductService;

    public function __construct(
        ProductMapRepository $productMapRepository,
        UpdateLocalProductService $updateLocalProductService,
        WebhooksRepository $webhooksRepository
    ) {
        $this->productMapRepository = $productMapRepository;
        $this->updateLocalProductService = $updateLocalProductService;

        parent::__construct($productMapRepository, $webhooksRepository);
    }

    /**
     * {@inheritDoc}
     *
     * @phpstan-assert-if-true int $this->localId
     * @phpstan-assert-if-true ProductBase $this->productBase
     */
    public function shouldHandle(Webhook $webhook) : bool
    {
        if (! $this->localId = $this->getLocalId($webhook)) {
            throw new WebhookProcessingException('Local product ID not found for remote product ID: '.$webhook->remoteResourceId);
        }

        if (($this->productBase = $this->getProductBase($webhook))->parentId) {
            return false;
        }

        return parent::shouldHandle($webhook);
    }

    /**
     * {@inheritDoc}
     */
    public function handle(Webhook $webhook) : void
    {
        if (! $this->shouldHandle($webhook)) {
            return;
        }

        $this->updateLocalProductService->update($this->productBase, $this->localId);

        $this->maybeScheduleVariantJobs($this->productBase->variants);
    }

    /**
     * Schedules variant jobs if necessary.
     *
     * Scheduling the jobs avoids any possible race conditions where parents may be updated after their children.
     * When WooCommerce updates children it depends on database content from the parent, so we need to ensure that
     * the parent is updated first.
     *
     * @param ?string[] $variantIds
     * @return void
     */
    protected function maybeScheduleVariantJobs(?array $variantIds) : void
    {
        if (empty($variantIds)) {
            return;
        }

        ListRemoteVariantsJobHandler::scheduleListVariantsJob(
            ListRemoteVariantsJobHandler::getChunkedIds($variantIds)
        );
    }
}
