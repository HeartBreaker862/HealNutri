<?php
	require_once('config.php');

	mysqli_report(MYSQLI_REPORT_STRICT);

	function abre_bd() {
		try {
			$conn = new mysqli(BD_LOCAL, BD_USER, BD_SENHA, BD_NAME, BD_PORTA);
			return $conn;
		} catch (Exception $e) {
			echo $e->getMessage();
			return null;
		}
	}

	function fecha_bd($conn) {
		try {
			mysqli_close($conn);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
}