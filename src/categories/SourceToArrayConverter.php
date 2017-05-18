<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 5/18/17
 * Time: 11:03 AM
 */

namespace pastuhov\ymlcatalog\categories;


use yii\base\Component;

class SourceToArrayConverter extends Component
{
    public $source = null;
    protected $result = [];
    public function convert() {
        $this->result = [];
        $this->parseList();

        return $this->result;
    }

    protected function parseList() {
        $source = str_replace("\n\n", "\n", str_replace("\r", "\n", $this->source));
        $rows = explode("\n", $source);
        foreach ($rows as $line => $row) {
            $fullName = trim($row);
            if (empty($fullName)) {
                continue;
            }

            $this->parseRow($fullName, $line);
        }
    }

    /**
     * @param $fullName
     * @param $line
     * @param $parentName
     * @return array
     */
    protected function parseRow($fullName, $line)
    {
        $id = md5($fullName);
        $result = [
            'id' => $id,
            'fullName' => $fullName,
            'line' => $line,
        ];

        $lastSlashPosition = mb_strrpos($fullName, '/');
        if ($lastSlashPosition) {
            do {
                $parentName = mb_substr($fullName, 0, $lastSlashPosition);
                $parentId = md5($parentName);
                $name = mb_substr($fullName, $lastSlashPosition + 1);
                $result = array_merge($result, [
                    'name' => $name,
                    'parent' => md5($parentName),
                ]);
                if (isset($this->result[$parentId])) {
                    break;
                } else {
                    $this->parseRow($parentName, $line);
                }
            } while(true);
        } else {
            $result['name'] = $fullName;
        }

        $this->result[$result['id']] = $result;
    }
}