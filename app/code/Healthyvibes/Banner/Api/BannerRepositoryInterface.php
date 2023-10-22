<?php

namespace Healthyvibes\Banner\Api;

interface BannerRepositoryInterface
{
    /**
     * Retrieve Banner.
     *
     * @param int $bannerId
     * @return \Healthyvibes\Banner\Api\Data\BannerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($bannerId);

    /**
     * Delete Banner.
     *
     * @param \Healthyvibes\Banner\Api\Data\BannerInterface $banner
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Healthyvibes\Banner\Api\Data\BannerInterface $banner);

    /**
     * Delete Banner by ID.
     *
     * @param int $bannerId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($bannerId);
}
