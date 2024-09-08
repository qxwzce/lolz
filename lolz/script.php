<?
if (isset($_POST["chat_user_message"])) {
    $answer = $_POST["chat_user_message"];
    header('Content-Type: application/json');
    echo json_encode($answer);
}
?>