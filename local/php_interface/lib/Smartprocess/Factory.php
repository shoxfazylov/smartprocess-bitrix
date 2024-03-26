<?php

namespace Custom\SmartProcess;

use \Bitrix\Main;
use \Bitrix\Crm\Service\Container;
use \Bitrix\Crm\Service\Factory\Dynamic;
use \Bitrix\Main\UserGroupTable;

Main\Loader::requireModule('crm');

class Factory extends Dynamic
{
    public function getUserFieldsInfo(): array
    {
        $group = UserGroupTable::getRow([
            'filter' => [
                'USER_ID' => $GLOBALS["USER"]->GetID(),
                'GROUP_ID' => SHOW_GROUP_ID,
                'GROUP.ACTIVE' => 'Y'
            ],
            'select' => ['GROUP_ID', 'GROUP_CODE' => 'GROUP.STRING_ID'],
        ]);

        $fields = parent::getUserFieldsInfo();
        if(!$group){
            $fields['UF_CRM_2_1711393736']['ATTRIBUTES'][] = \CCrmFieldInfoAttr::NotDisplayed;
        }
        return $fields;
    }
}