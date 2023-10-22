<?php

namespace Healthyvibes\Banner\Controller\Adminhtml;

class Banner extends Actions
{
    /**
     * Form session key
     *
     * @var string
     */
    protected $formSessionKey = 'healthyvibes_banner_form_data';

    /**
     * Allowed Key
     *
     * @var string
     */
    protected $allowedKey = 'Healthyvibes_Banner::manage_banners';

    /**
     * Model class name
     *
     * @var string
     */
    protected $modelClass = \Healthyvibes\Banner\Model\Banner::class;

    /**
     * Active menu key
     *
     * @var string
     */
    protected $activeMenu = 'Healthyvibes_Banner::banner';

    /**
     * Status field name
     *
     * @var string
     */
    protected $statusField = 'is_active';

    /**
     * Save request params key
     *
     * @var string
     */
    protected $paramsHolder = 'post';
}
