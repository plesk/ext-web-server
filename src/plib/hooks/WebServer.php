<?php
// Copyright 1999-2017. Parallels IP Holdings GmbH.

class Modules_WebServer_WebServer extends pm_Hook_WebServer
{
    public function getDomainApacheConfig(pm_Domain $domain)
    {
        if (!$this->isEnabled($domain)) {
            return '';
        }
        return '# Apache config for domain: ' . $domain->getName();
    }

    public function getDomainNginxConfig(pm_Domain $domain)
    {
        if (!$this->isEnabled($domain)) {
            return '';
        }
        return '# Nginx config for domain: ' . $domain->getName();
    }

    private function isEnabled(pm_Domain $pmDomain)
    {
        $domain = new Modules_WebServer_Domain($pmDomain->getId());
        return $domain->isEnabled();
    }
}
