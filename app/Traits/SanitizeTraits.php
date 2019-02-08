<?php

namespace App\Traits;

use App\Helpers\StringHelper;
use Dingo\Api\Http\Request;

/**
 * Trait SanitizeTraits
 *
 * @package App\Traits
 */
trait SanitizeTraits
{
    /**
     * @param \Dingo\Api\Http\Request $request
     * @param array                   $field
     */
    public function sanitize(Request $request, array $field): void
    {
        $request->replace(
            $this->process($request->all(),
                $field)
        );
    }

    /**
     * @param array $data
     * @param array $field
     *
     * @return array
     */
    public function sanitizeJson(array $data, array $field): array
    {
        return $this->process(
            $data,
            $field
        );
    }


    /**
     * @param array $input
     * @param array $field
     *
     * @return array
     */
    protected function process(array $input,array $field): array
    {
        if (!empty($field)) {

            foreach ($field as $name => $regle) {
                $namesToProcess = explode('.',$name);

                $this->processName($input, $namesToProcess, $regle);
            }
        }
        return $input;
    }

    /**
     * @param $input
     * @param $namesToProcess
     * @param $regle
     */
    protected function processName(&$input,$namesToProcess,$regle){


        $nameToProcess = current($namesToProcess);
        $id = key($namesToProcess);

        if(count($namesToProcess) > 1) {
            unset($namesToProcess[$id]);
            if($nameToProcess == '*'){
                $nameToProcess = current($namesToProcess);
                $id = key($namesToProcess);
                if (is_array($input) && \key_exists($nameToProcess, $input)) {
                    foreach ($input[$nameToProcess] as $key => $value) {
                        $this->processName($input[$nameToProcess], [$key], $regle);
                    }
                }
                unset($namesToProcess[$id]);

            }else {
                if (is_array($input) && \key_exists($nameToProcess, $input)) {
                    $this->processName($input[$nameToProcess], $nameToProcess, $regle);
                }
            }
        }else {
            if (\key_exists($nameToProcess, $input)) {
                $input[$nameToProcess] = StringHelper::sanitize($input[$nameToProcess], $regle);
            }
        }
    }

}

