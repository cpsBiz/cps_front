<? include_once $_SERVER['DOCUMENT_ROOT'] . "/isTest.php"; ?>
<?
// 데이터베이스 연결 정보
if ($isTest) {
  $host = '192.168.150.80:3306';
  $username = 'CPS';
  $password = 'Emfla2017!@#';
  $database = 'CPS';
} else {
  $host = '192.168.3.15:3306';
  $username = 'CPS';
  $password = 'Emfla2017!@#';
  $database = 'CPS';
}
// MySQL 데이터베이스 연결
$con = mysqli_connect($host, $username, $password, $database);

// 연결 확인
if (!$con) {
  die('MySQL 연결 실패: ' . mysqli_connect_error());
  header('Location:/500.php');
}
mysqli_set_charset($con, 'utf8');

class ApiResponse
{
  public static function error($code, $message)
  {
    echo json_encode([
      'resultCode' => $code,
      'resultMessage' => $message
    ]);
    exit;
  }

  public static function success($data = null)
  {
    $response = [
      'resultCode' => '0000',
      'resultMessage' => 'Success'
    ];
    if ($data) {
      $response['data'] = $data;
    }
    echo json_encode($response);
    exit;
  }
}

class DatabaseHandler
{
  private $con;
  private $stmt;

  public function __construct($connection)
  {
    $this->con = $connection;
  }

  public function executeQuery($sql, $types = '', $params = [])
  {
    $this->stmt = mysqli_stmt_init($this->con);

    if (!mysqli_stmt_prepare($this->stmt, $sql)) {
      throw new Exception('Database preparation failed');
    }

    if ($types && $params) {
      mysqli_stmt_bind_param($this->stmt, $types, ...$params);
    }

    mysqli_stmt_execute($this->stmt);

    if (stripos(trim($sql), 'SELECT') === 0) {
      return mysqli_stmt_get_result($this->stmt);
    }

    return mysqli_stmt_affected_rows($this->stmt) > 0;
  }

  public function __destruct()
  {
    if ($this->stmt) {
      mysqli_stmt_close($this->stmt);
    }
  }
}

class AESCipher
{
  private const AES_ALGORITHM = 'AES-128-ECB';
  private const SECRET_KEY = 'CPS_REWORDSECRET';

  public static function decrypt($encryptedText)
  {
    try {
      $key = self::SECRET_KEY;
      $decrypted = openssl_decrypt(
        base64_decode($encryptedText),
        self::AES_ALGORITHM,
        $key,
        OPENSSL_RAW_DATA
      );
      return $decrypted;
    } catch (Exception $e) {
      error_log($e->getMessage());
      return null;
    }
  }

  public static function encrypt($plainText)
  {
    try {
      $key = self::SECRET_KEY;
      $encrypted = openssl_encrypt(
        $plainText,
        self::AES_ALGORITHM,
        $key,
        OPENSSL_RAW_DATA
      );
      return base64_encode($encrypted);
    } catch (Exception $e) {
      error_log($e->getMessage());
      return null;
    }
  }
}
