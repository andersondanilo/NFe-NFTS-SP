<?php
namespace NotaFiscalSP\Transformers\AsyncNF;

use NotaFiscalSP\Constants\Requests\HeaderConstants;
use NotaFiscalSP\Constants\Requests\SimpleFieldsConstants;
use NotaFiscalSP\Contracts\InputTransformer;
use NotaFiscalSP\Entities\BaseInformation;
use NotaFiscalSP\Helpers\General;
use NotaFiscalSP\Transformers\NfAbstract;
use Spatie\ArrayToXml\ArrayToXml;

class  PedidoConsultaGuia extends NfAbstract
{
    public function makeXmlRequest(BaseInformation $information, $params = null)
    {
        $request = [];
        $request[HeaderConstants::CPFCNPJ_SENDER] = [SimpleFieldsConstants::CNPJ => $information->getCnpj()];
        $request[SimpleFieldsConstants::IM_PROVIDER] = $information->getIm();
        $request[SimpleFieldsConstants::INCIDENCE] = General::getKey($params, SimpleFieldsConstants::INCIDENCE);
        $request[SimpleFieldsConstants::SITUATION] = General::getKey($params, SimpleFieldsConstants::SITUATION);

        return ArrayToXml::convert($request, [
            'rootElementName' => 'p1:PedidoConsultaGuia',
            '_attributes' => [
                'xmlns:p1' => 'http://www.prefeitura.sp.gov.br/nfe',
                'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance'
            ],
        ], true, 'UTF-8');
    }
}