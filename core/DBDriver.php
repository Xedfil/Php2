<?php 
	namespace core;

	class DBDriver
	{	
		const FETCH_ALL = 'all';
		const FETCH_ONE = 'one';

		private $pdo;

		function __construct(\PDO $pdo)
		{
			$this->pdo = $pdo;
		}

		public function select($sql, array $params = [], $fetch = self::FETCH_ALL)
		{
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute($params);

			return $fetch === self::FETCH_ALL ? $stmt->fetchAll() : $stmt->fetch();
		}

		public function insert($table, array $params)
		{
			$columns = sprintf('(%s)', implode(', ', array_keys($params)));
			$masks = sprintf('(:%s)', implode(', :', array_keys($params)));

			$sql = sprintf('INSERT INTO %s %s VALUES %s', $table, $columns, $masks);

			$stmt = $this->pdo->prepare($sql);
			$stmt->execute($params);

			return $this->pdo->lastInsertId();
		}

		public function update($table, array $paramsForSet, string $where, array $paramForWhere)
		{	
			$set = [];
			foreach ($paramsForSet as $key => $value) {
				$set[] = sprintf('%1$s=:%1$s', $key);
			}

			$set = implode(', ', $set);
			$sql = sprintf('UPDATE %s SET %s WHERE %s', $table, $set, $where);
			$params = array_merge($paramsForSet, $paramForWhere);
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute($params);
		}

		public function delete($table, string $where, array $params)
		{
			$sql = sprintf('DELETE FROM %s WHERE %s', $table, $where);
			
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute($params);
		}
	}