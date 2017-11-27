<?php
// Copyright 1999-2017. Parallels IP Holdings GmbH.

class IndexController extends pm_Controller_Action
{
    protected $_accessLevel = 'admin';

    public function indexAction()
    {
        $this->view->list = $this->getList();
    }

    public function indexDataAction()
    {
        $this->_helper->json($this->getList()->fetchData());
    }

    private function getList()
    {
        $data = [];
        foreach (pm_Domain::getAllDomains() as $pmDomain) {
            $domain = new Modules_WebServer_Domain($pmDomain->getId());
            if ($domain->isEnabled()) {
                $status = 'Enabled';
                $link = pm_Context::getActionUrl('index', 'disable') . '/id/' . $pmDomain->getId();
                $linkTitle = 'Disable';
            } else {
                $status = 'Disabled';
                $link = pm_Context::getActionUrl('index', 'enable') . '/id/' . $pmDomain->getId();
                $linkTitle = 'Enable';
            }
            $data[] = [
                'name' => $pmDomain->getDisplayName(),
                'status' => $status,
                'link' => "<a href='{$link}'>{$linkTitle}</a>",
            ];
        }

        $list = new pm_View_List_Simple($this->view, $this->_request);
        $list->setData($data);
        $list->setColumns([
            'name' => [
                'title' => 'Domain name',
            ],
            'status' => [
                'title' => 'Status',
            ],
            'link' => [
                'title' => 'Operations',
                'noEscape' => true,
            ]
        ]);
        $list->setDataUrl(['action' => 'index-data']);
        return $list;
    }

    public function enableAction()
    {
        $this->setState(true);
    }

    public function disableAction()
    {
        $this->setState(false);
    }

    private function setState($enable = true)
    {
        $domainId = $this->_request->getParam('id');

        if (empty($domainId)) {
            throw new pm_Exception('Domain is not specified');
        }

        $domain = new Modules_WebServer_Domain($domainId);
        $enable ? $domain->setEnabled() : $domain->setDisabled();

        $webServer = new pm_WebServer();
        $webServer->updateDomainConfiguration(new pm_Domain($domainId));

        $status = $enable ? 'Enabled' : 'Disabled';
        $this->_status->addInfo("Domain status was changed to: \"{$status}\".");
        $this->redirect(pm_Context::getBaseUrl());
    }
}
