<?php

namespace Maatwebsite\Excel\Concerns;

interface WithValidation
{
    /**
	 * @param @rows - row columns data value
     * @return array
     */
    public function rules($rows): array;
}
