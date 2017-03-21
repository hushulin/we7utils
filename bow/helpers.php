<?php
if ( ! function_exists('bow_build_settings') ) {
	function bow_build_settings($w , $dir)
	{
		$we7config = $w['config']['db'];

		if ( !$we7config['slave_status'] ) {
			$settings = [
				'settings' => [
					'db' => [
			            'driver' => 'mysql',
			            'host' => $we7config['master']['host'],
			            'database' => $we7config['master']['database'],
			            'username' => $we7config['master']['username'],
			            'password' => $we7config['master']['password'],
			            'charset'   => $we7config['master']['charset'],
			            'collation' => 'utf8_general_ci',
			            'prefix'    => $we7config['master']['tablepre'],
					],

					// Encryption settings
			        'encryption' => [
			            'key' => 'Nv7QU2Zuj9CWjuxxB2Edt3LWML53IAsF',
			            'cipher' => 'AES-256-CBC',
			        ],

			        // Logger settings
			        'logger' => [
			            'name' => 'eric-log',
			            'path' => $dir . '/logs/app.log',
			            'level' => \Monolog\Logger::DEBUG,
			        ],
				],
			];
		}else {
			$settings = [
				'settings' => [
					'db' => [
						'write' => [
			                'host' => [$we7config['master']['host']],
			            ],
			            'read' => [
			                'host' => [$we7config['slave']['host']],
			            ],
			            'driver' => 'mysql',
			            'host' => $we7config['master']['host'],
			            'database' => $we7config['master']['database'],
			            'username' => $we7config['master']['username'],
			            'password' => $we7config['master']['password'],
			            'charset'   => $we7config['master']['charset'],
			            'collation' => 'utf8_general_ci',
			            'prefix'    => $we7config['master']['tablepre'],
					],

					// Encryption settings
			        'encryption' => [
			            'key' => 'Nv7QU2Zuj9CWjuxxB2Edt3LWML53IAsF',
			            'cipher' => 'AES-256-CBC',
			        ],

			        // Logger settings
			        'logger' => [
			            'name' => 'eric-log',
			            'path' => $dir . '/logs/app.log',
			            'level' => \Monolog\Logger::DEBUG,
			        ],
				],
			];
		}

		return $settings;
	}
}

if ( ! function_exists('bow_template_parse') ) {
	function bow_template_parse($from , $data = [])
	{
		$dataObject = new \ArrayObject($data);
		$view = new \Spindle\View($from , '' , $dataObject);
		return $view;
	}
}
