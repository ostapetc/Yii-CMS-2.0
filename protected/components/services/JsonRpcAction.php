<?
class JsonRpcAction extends CAction
{
    public function actionIndex()
    {
        $this->failIfNotAJsonRpcRequest();
        Yii::beginProfile('service.request');
        $request = $result = null;
        try {
            $request = json_decode(file_get_contents('php://input'), true);
            $this->failIfRequestIsInvalid($request);
            try {
                $class = new ReflectionClass($this->controller);

                if (!$class->hasMethod($request['method']))
                    throw new JsonRpcException("Method not found", -32601);

                $method = $class->getMethod($request['method']);

                ob_start();

                Yii::beginProfile('service.request.action');
                $result = $method->invokeArgs($this->controller, isset($request['params'])? $request['params'] : null);
                Yii::endProfile('service.request.action');

                $output = ob_get_clean();
                if ($output) Yii::log($output, CLogger::LEVEL_INFO, 'service.output');

            } catch (Exception $e) {
                Yii::log($e, CLogger::LEVEL_ERROR, 'service.error');
                throw new JsonRpcException($e->getMessage(), -32603);
            }

            if (!empty($request['id'])) {
                echo json_encode(array(
                    'jsonrpc' => '2.0',
                    'id' => $request['id'],
                    'result' => $output,
                ));
            }
        } catch (JsonRpcException $e) {
            echo json_encode(array(
                'jsonrpc' => '2.0',
                'id' => isset($request['id'])? $request['id'] : null,
                'error' => $e->getErrorAsArray(),
            ));
        }
        Yii::endProfile('service.request');
    }

    private function failIfNotAJsonRpcRequest()
    {
        if (Yii::app()->request->requestType != 'POST'
            || empty($_SERVER['CONTENT_TYPE'])
            || $_SERVER['CONTENT_TYPE'] != "application/json-rpc"
        ) throw new CHttpException(404, "Page not found");
    }

    /**
     * @param $request
     * @throws JsonRpcException
     */
    private function failIfRequestIsInvalid($request)
    {
        if ($request === null
            || !isset($request['jsonrpc'])
            || $request['jsonrpc'] != '2.0'
            || !isset($request['method'])
        ) throw new JsonRpcException("Invalid Request", -32600);
    }

}

class JsonRpcException extends CException
{
    const PARSE_ERROR = -32700;
    const INVALID_REQUEST = -32600;
    const METHOD_NOT_FOUND = -32601;
    const INVALID_PARAMS = -32602;
    const INTERNAL_ERROR = -32603;

    private $data = null;

    public function __construct($message, $code = -32603, $data = null)
    {
        $this->data = $data;
        parent::__construct($message, $code);
    }

    public function getErrorAsArray() {
        $result = array(
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
        );
        if ($this->data !== null) $result['data'] = $this->data;
        return $result;
    }
}