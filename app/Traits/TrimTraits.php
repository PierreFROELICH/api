<?php

namespace App\Traits;

use Dingo\Api\Http\Request;

/**
 * Trait TrimTraits
 *
 * @package App\Traits
 */
trait TrimTraits
{
    /**
     * @param \Dingo\Api\Http\Request $request
     * @param array                   $field
     */
    public function trim(Request $request, array $field): void
    {
        $request->replace(
            $this->process(
                $request->all(),
                $field
            )
        );
    }

    /**
     * @param array $data
     * @param array $field
     *
     * @return array
     */
    public function trimJson(array $data, array $field): array
    {

        return $this->process($data, $field);
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

            foreach ($field as $name => $nullable) {
                $namesToProcess = explode('.',$name);

                $this->processName($input, $namesToProcess, $nullable);
            }
        }
        return $input;
    }

    /**
     * @param $input
     * @param $namesToProcess
     * @param $nullable
     */
    protected function processName(&$input,$namesToProcess,$nullable){


        $nameToProcess = current($namesToProcess);
        $id = key($namesToProcess);

        if(count($namesToProcess) > 1) {
            unset($namesToProcess[$id]);
            if($nameToProcess == '*'){
                $nameToProcess = current($namesToProcess);
                $id = key($namesToProcess);
                if (is_array($input) && \key_exists($nameToProcess, $input)) {
                    foreach ($input[$nameToProcess] as $key => $value) {
                        $this->processName($input[$nameToProcess], [$key], $nullable);
                    }
                }
                unset($namesToProcess[$id]);

            }else {
                if (is_array($input) && \key_exists($nameToProcess, $input)) {
                    $this->processName($input[$nameToProcess], $nameToProcess, $nullable);
                }
            }
        }else {
            if (\key_exists($nameToProcess, $input)) {
                $input[$nameToProcess] = trim($input[$nameToProcess]);
                if ($nullable && empty($input[$nameToProcess])) {
                    $input[$nameToProcess] = null;
                }
            }
        }
    }

}
