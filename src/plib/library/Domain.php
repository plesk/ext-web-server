<?php
// Copyright 1999-2017. Plesk International GmbH.

class Modules_WebServer_Domain
{
    const STATUS_ENABLED = 'enabled';
    const STATUS_DISABLED = 'disabled';

    private $domainId;

    public function __construct($domainId)
    {
        $this->domainId = $domainId;
    }

    public function isEnabled()
    {
        $status = pm_Settings::get('status-' . $this->domainId, static::STATUS_DISABLED);
        return static::STATUS_ENABLED == $status;
    }

    public function setEnabled()
    {
        pm_Settings::set('status-' . $this->domainId, static::STATUS_ENABLED);
    }

    public function setDisabled()
    {
        pm_Settings::set('status-' . $this->domainId, static::STATUS_DISABLED);
    }
}
