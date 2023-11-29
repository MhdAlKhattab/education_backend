<!DOCTYPE html>
<html>
<head>
    <title>Notification</title>
</head>
<body>
    <p>السلام عليكم</p>
    <p>لديكم طلب <span>{{ $mailData['type'] }}</span> جديد من المشرفة <span style="color:green;">{{ $mailData['supervisor_name'] }}</span></p>
    <p>و لكم جزيل الشكر</p>
</body>
</html>