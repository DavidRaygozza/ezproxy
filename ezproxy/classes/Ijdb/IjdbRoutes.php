<?php
namespace Ijdb;

class IjdbRoutes implements \Ninja\Routes {
	private $loginsTable;
	private $authorsTable;
    private $htmlTable;
    private $domainTable;
    private $tempTable;
    private $combinedInfoIPTable;

	public function __construct() {
		include __DIR__ . '/../../includes/DatabaseConnection.php';

		$this->loginsTable = new \Ninja\DatabaseTable($pdo, 'log', 'id');
        $this->domainTable = new \Ninja\DatabaseTable($pdo, 'domain', 'id');
        $this->combinedInfoIPTable = new \Ninja\DatabaseTable($pdo, 'combinedinfosession3', 'id');
        $this->tempTable = new \Ninja\DatabaseTable($pdo, 'tempTable', 'id');
		$this->authorsTable = new \Ninja\DatabaseTable($pdo, 'author', 'id');
	}

	public function getRoutes(): array {
		$visitController = new \Ijdb\Controllers\Visit($this->loginsTable, $this->domainTable, $this->tempTable, $this->combinedInfoIPTable, $this->authorsTable);

		$routes = [
			'visit/list' => [
				'GET' => [
					'controller' => $visitController,
					'action' => 'list'
				],
                'POST' => [
                    'controller' => $visitController,
                        'action' => 'list'
                ]
			],
			'' => [
				'GET' => [
					'controller' => $visitController,
					'action' => 'list'
				]
			]
		];

		return $routes;
	}

}
