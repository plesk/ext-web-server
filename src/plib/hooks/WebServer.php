<?php
// Copyright 1999-2017. Plesk International GmbH.

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

    public function getWebmailApacheConfig(pm_Domain $domain, $type)
    {
        if (!$this->isEnabled($domain)) {
            return '';
        }
        return "Header add X-Custom-Ext-Web-Server {$type}";
    }

    public function getWebmailNginxConfig(pm_Domain $domain, $type)
    {
        if (!$this->isEnabled($domain)) {
            return '';
        }
        return "add_header X-Custom-Ext-Web-Server {$type};";
    }

    private function isEnabled(pm_Domain $pmDomain)
    {
        $domain = new Modules_WebServer_Domain($pmDomain->getId());
        return $domain->isEnabled();
    }
}
