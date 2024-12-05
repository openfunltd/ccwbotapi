<?php

class ApiController extends MiniEngine_Controller
{
    public function queryAction()
    {
        $id = $_GET['id'] ?? null;

        $class = "APICommand_{$id}";
        if (!class_exists($class)) {
            return $this->json([
                'error' => true,
                'message' => 'Command not found',
            ]);
        }
        $params = $_GET['params'] ?? [];

        return $this->json([
            'error' => false,
            'result' => call_user_func([$class, 'run'], $params),
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
