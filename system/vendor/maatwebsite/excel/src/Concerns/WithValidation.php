<?php

namespace Maatwebsite\Excel\Concerns;

interface WithValidation
{
    /**
     * @return array
     */
    public function rules($rows): array;
}
