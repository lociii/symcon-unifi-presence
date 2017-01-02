<?php

include_once(__DIR__ . '/../shared/BaseModule.php');
include_once(__DIR__ . '/UniFi.php');

class UniFiPresence extends IPSBaseModule
{
    protected $config = array('ufp_url', 'ufp_username', 'ufp_password', 'ufp_mac', 'ufp_interval');

    public function Create()
    {
        parent::Create();

        $this->RegisterPropertyString('ufp_url', '');
        $this->RegisterPropertyString('ufp_username', '');
        $this->RegisterPropertyString('ufp_password', '');
        $this->RegisterPropertyString('ufp_mac', '');
        $this->RegisterPropertyInteger('ufp_interval', 1);

        if (!IPS_VariableProfileExists('LOCI.Presence')) {
            IPS_CreateVariableProfile('LOCI.Presence', 0);
        }

        $this->RegisterTimer('update', $this->ReadPropertyInteger('ufp_interval'), 'LOCIUFP_Update($_IPS[\'TARGET\']);');
    }

    protected function OnConfigValid()
    {
        $this->SetTimerInterval('update', $this->ReadPropertyInteger('ufp_interval') * 1000 * 60);
        $this->MaintainVariable('presence', 'Presence', 0, 'LOCI.Presence', 10, true);
        $this->SetStatus(102);
    }

    protected function OnConfigInvalid()
    {
        $this->SetTimerInterval('update', 0);
        $this->SetStatus(104);
    }

    public function Update()
    {
        $url = $this->ReadPropertyString('ufp_url');
        $username = $this->ReadPropertyString('ufp_username');
        $password = $this->ReadPropertyString('ufp_password');
        $mac = $this->ReadPropertyString('ufp_mac');

        $unifi = new UniFi($url, $username, $password);
        SetValue($this->GetIDForIdent('presence'), $unifi->isClientActive($mac));
    }
}
