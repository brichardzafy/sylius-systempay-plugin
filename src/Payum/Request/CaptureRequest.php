<?php
declare(strict_types=1);

namespace Sylius\SystempayPlugin\Payum\Request;

use Payum\Core\Request\Capture;

class CaptureRequest extends Capture
{

    /**
     * @var array
     */
    protected $dataForm;

    /**
     * @return array
     */
    public function getDataForm(): array
    {
        return $this->dataForm;
    }

    /**
     * @param array $dataForm
     */
    public function setDataForm(array $dataForm): void
    {
        $this->dataForm = $dataForm;
    }
    
}