<?php
// إظهار الأخطاء داخل البوت في حال حدوث خلل برمجي
ini_set('display_errors', 1);
error_reporting(E_ALL);

// --- الإعدادات ---
$token = "8173047143:AAHVVPHJ7SQnG5lZ68JNW9EpEMiUbriLPvE"; 
$website = "https://api.telegram.org/bot".$token;

// --- استقبال الطلبات ---
$input = file_get_contents('php://input');
$update = json_decode($input, TRUE);

if (!$update) {
    exit("نظام الظل المبرمج يعمل.. بانتظار أوامر السيد.");
}

$chatId = $update["message"]["chat"]["id"];
$text = $update["message"]["text"];

// --- الوظائف الرئيسية ---
try {
    if ($text == "/start") {
        $msg = "💀 **الظل المبرمج جاهز.**\n\nأرسل رقم الضحية (بالصيغة الدولية +964...) وسأقوم بمهمتي.";
        sendMessage($chatId, $msg);
    } 
    elseif (strpos($text, '+') === 0) {
        // هنا يتم تنفيذ منطق البحث
        $msg = "🔍 جاري فحص الرقم: $text ...";
        sendMessage($chatId, $msg);
        
        // محاكاة سحب البيانات (هنا تربط قاعدة بياناتك)
        $data = "تم العثور على بيانات المبتز.\nالاسم: غير معروف\nالموقع: العراق\nالحالة: نشط";
        sendMessage($chatId, $data);
    }
} catch (Exception $e) {
    // في حال حدوث أي خطأ سيظهر لك هنا في البوت مباشرة
    sendMessage($chatId, "⚠️ **خطأ في النظام:** " . $e->getMessage());
}

// --- دالة إرسال الرسائل ---
function sendMessage($chatId, $message) {
    global $website;
    $url = $website."/sendMessage?chat_id=".$chatId."&text=".urlencode($message);
    file_get_contents($url);
}
?>
