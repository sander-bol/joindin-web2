<?php
namespace Talk;

use Application\BaseApi;

class TalkTypeApi extends BaseApi
{
    /**
     * Retrieve list of talk types from the API
     */
    public function getTalkTypes(): array
    {
        $url                           = $this->baseApiUrl . '/v2.1/talk_types';
        $queryParams['resultsperpage'] = 0;

        $result = $this->apiGet($url, $queryParams);

        return json_decode($result, true);
    }

    /**
     * Return the list of talk types in a format suitable for a choice list
     */
    public function getTalkTypesChoiceList(): array
    {
        $types = [];

        $list = $this->getTalkTypes();
        foreach ($list['talk_types'] as $type) {
            $types[$type['title']] = $type['title'];
        }

        return $types;
    }
}
