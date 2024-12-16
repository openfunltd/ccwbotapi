<?php

class ApiController extends MiniEngine_Controller
{
    public function queryAction()
    {
        $id = $_GET['id'] ?? null;
        $params = $_GET['params'] ?? [];

        try {
            $result = APICommand::query($id, $params);
        } catch (Exception $e) {
            return $this->json([
                'error' => true,
                'message' => 'Command not found: ' . $e->getMessage(),
            ]);
        }
        return $this->json([
            'error' => false,
            'result' => $result,
        ]);
    }

    public function listAction()
    {
        $ret = new StdClass;
        $ret->error = false;
        $ret->commands = [];
        foreach (glob(__DIR__ . '/../libraries/APICommand/*.php') as $file) {
            $class_name = basename($file, '.php');
            $command = new StdClass;
            $command->id = $class_name;
            $command->name = call_user_func(["APICommand_{$class_name}", "getName"]);
            $command->description = call_user_func(["APICommand_{$class_name}", "getDescription"]);
            $command->params = call_user_func(["APICommand_{$class_name}", "getParams"]);

            $ret->commands[] = $command;
        }
        return $this->json($ret);
    }
}
