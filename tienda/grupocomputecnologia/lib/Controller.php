<?php
//require_once '../model/Main.php';
class Controller
{
    public function __call($name, $arguments)
    {
        die("Error! El metodo {$name}  no esta definido.");
    }

    public function Select($p)
    {
        $obj = new Main();
        $obj->table = $p['table'] ?? '';
        $data = array();

        $data['rows'] = $obj->getList();
        $data['name'] = $p['name'] ?? '';
        $data['id'] = $p['id'] ?? '';
        $data['code'] = $p['code'] ?? '';
        $data['disabled'] = $p['disabled'] ?? '';

        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/_Select.php');
        return $view->renderPartial();
    }

    public function Select_ajax($p)
    {
        $obj = new Main();
        $obj->table = $p['table'] ?? '';
        $data = array();

        $data['rows'] = $obj->getList();
        $data['name'] = $p['name'] ?? '';
        $data['id'] = $p['id'] ?? '';
        $data['code'] = $p['code'] ?? '';

        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/_Select_ajax.php');
        return $view->renderPartial();
    }

    public function Select_next($p)
    {
        $obj = new Main();
        $obj->table = $p['table'] ?? '';
        $data = array();

        $data['rows'] = $obj->getList();
        $data['name'] = $p['name'] ?? '';
        $data['id'] = $p['id'] ?? '';
        $data['code'] = $p['code'] ?? '';

        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/_Select_next.php');
        return $view->renderPartial();
    }

    public function Pagination($p)
    {
        $data = array();
        $data['rows'] = $p['rows'] ?? 0;
        $data['query'] = $p['query'] ?? '';
        $data['url'] = $p['url'] ?? '';
        $data['order'] = $p['order'] ?? '';
        $data['total'] = $p['total'] ?? 0;
        $data['consulta'] = $p['consulta'] ?? '';

        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/_Pagination.php');
        return $view->renderPartial();
    }

    public function Pagination_l($p)
    {
        $data = array();
        $data['rows'] = $p['rows'] ?? 0;
        $data['query'] = $p['query'] ?? '';
        $data['url'] = $p['url'] ?? '';
        $data['order'] = $p['order'] ?? '';

        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/_Pagination_l.php');
        return $view->renderPartial();
    }

    public function grilla($titulo, $controller, $cabecera, $rows, $pag, $edit, $view, $select = false)
    {
        $objtotal = new Main();
        $data = array();
        $data['total'] = $objtotal->getnum();
        $data['titulo'] = $titulo;
        $data['cabecera'] = $cabecera;
        $data['rows'] = $rows;
        $data['edit'] = $edit;
        $data['view'] = $view;
        $data['select'] = $select;
        $data['controller'] = $controller;
        $data['pag'] = $pag;

        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/_grilla.php');
        $view->setLayout('template/Layout.php');
        return $view->renderPartial();
    }
}
?>