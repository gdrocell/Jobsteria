<?PHP
	class User_project_awardDAO {
		var $dbh;
		function __construct($dbh) {
		$this->dbh=$dbh;
		}
		protected function generateFilter($map) {
			$filterStr = "";
			foreach($map as $k => $v) {
				$filterStr .= " $k= ? AND";
			}
			$filterStr = substr($filterStr,0,strlen($filterStr)-4);			return $filterStr;
		}
		public function getUser_project_awardByAttributeMapInRange($fkMap, $r1, $r2) {
			$dbh=$this->dbh;
			$qStr="SELECT * FROM user_project_award WHERE " . self::generateFilter($fkMap) . " ORDER BY add_ts DESC LIMIT ? OFFSET ? ";
			$q=$dbh->prepare($qStr);
			$vals=array_values($fkMap);
			array_push($vals, $r1, $r2);
			$q->execute($vals);
			$returnTuples=array();
			while(($rs=$q->fetch(PDO::FETCH_OBJ))) {
				array_push($returnTuples,$rs);
			}
			return $returnTuples;
		}
		public function getAllUser_project_awardsInRange($r1, $r2) {
			$dbh=$this->dbh;
			$q = $dbh->prepare('SELECT * FROM user_project_award LIMIT ? OFFSET ?');
			$q->execute(array($r1, $r2));
			$returnTuples=array();
			while(($rs=$q->fetch(PDO::FETCH_OBJ))) {
				array_push($returnTuples,$rs);
			}
			return $returnTuples;
		}
		public function getAllUser_project_awards() {
			$dbh=$this->dbh;
			$q = $dbh->prepare('SELECT * FROM user_project_award');
			$q->execute();
			$returnTuples=array();
			while(($rs=$q->fetch(PDO::FETCH_OBJ))) {
				array_push($returnTuples,$rs);
			}
			return $returnTuples;
		}
		public function getUser_project_awardByAttributeMap($fkMap) {
			$dbh=$this->dbh;
			$qStr="SELECT * FROM user_project_award WHERE " . self::generateFilter($fkMap);
			$q=$dbh->prepare($qStr);
			$q->execute(array_values($fkMap));
			$returnTuples=array();
			while(($rs=$q->fetch(PDO::FETCH_OBJ))) {
				array_push($returnTuples,$rs);
			}
			return $returnTuples;
		}
		public function insertUser_project_award($map) {
			$dbh=$this->dbh;
			$genQuery = "INSERT INTO user_project_award %s VALUES %s";
			$colNames = "(";
			$colVals = "(";
			$valArr = array();
			foreach($map as $k => $v) {
				$colNames .= "$k ,";
				$colVals .= "? ,";
				array_push($valArr,$v);
			}
			$colNames = substr($colNames, 0, strlen($colNames)-1) . ")";
			$colVals = substr($colVals, 0, strlen($colVals)-1) . ")";
			$genQuery = sprintf($genQuery, $colNames, $colVals);
			$q=$dbh->prepare($genQuery);
			$q->execute($valArr);
		}
		public function updateUser_project_award($updateMap, $filterMap) {
			$dbh=$this->dbh;
			$genQuery = "UPDATE user_project_award SET %s WHERE %s";
			$toUpdate = str_replace("AND", ",", self::generateFilter($updateMap));
			$toFilter = self::generateFilter($filterMap);
			$genQuery = sprintf($genQuery, $toUpdate, $toFilter);
			$q=$dbh->prepare($genQuery);
			$q->execute(array_merge(array_values($updateMap),array_values($filterMap)));
		}
		public function deleteUser_project_award($deleteMap) {
			$dbh=$this->dbh;
			$genQuery = "DELETE FROM user_project_award WHERE " . self::generateFilter($deleteMap);
			$q=$dbh->prepare($genQuery);
			$q->execute(array_values($deleteMap));
		}
	}
?>
