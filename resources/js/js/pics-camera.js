Webcam.set({
    width: 320,
    height: 240,
    image_format: 'jpeg',
    jpeg_quality: 90
});
Webcam.attach('#my_camera');

var serial;
function setSerial() {
    serial = document.getElementById("serial").value;
}

function take_snapshot() {
    Webcam.snap( function(data_uri) {
        document.getElementById('my_result').innerHTML = '<img src="'+data_uri+'"/>';
        Webcam.upload( data_uri, '/routes/test', function(code, text) {

        } );
    } );
}

//const photoFormData = new FormData();
// photoFormData.append('card_serial', serial);
// photoFormData.append('card_image' ,data_uri);
// console.log(photoFormData);
// photoFormData.append();
// axios({
//     method: "POST",
//     url: "http://127.0.0.1:8001/api/users/account/images",
//     data: photoFormData,
//     headers: {
//         'Content-Type': 'multipart/form-data;',
//         'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiOWFlZTA1ZGZhMzhmYzM0ZGU2MjMyYmFiN2RhNTE2YjA5ZDRlMTRhYzY1MWMwOWNmZDYzYTgyNTAwYWY3NzExMDgyZDA2YTVmZGRmZTc3MGIiLCJpYXQiOjE1OTA5OTA0MDUsIm5iZiI6MTU5MDk5MDQwNSwiZXhwIjoxNjIyNTI2NDA1LCJzdWIiOiIzNyIsInNjb3BlcyI6WyJjdXN0b21lciJdfQ.IKDkVCHuOMCi6-Pd4GNe4IcopKvrbf4IuU8iVC6ZoGhLpmNh5c2jUAlOcmegcZDxC9j-BMStquNe79VttuciIMfDqF1OHM8OTHvUG9X59vXHbkvLlB4Z9S6sOxGt7EGd0Mx6sMvTiXtOc-tkA-cZu5fpwbgSVjOOz6bpTBxzrQLU-u-ZRHgAlZNsrwa4YdRQpOxQCaNULypllxFkj-rlXU4ywD6lLk5g1iq3ryralkTDTW8-ZwlMUMfc6PLu91TgVk7MOwPp37-DoAO3fOVVfkdj-2PqZYcCvh-KHn4ISbOq_tUR4d-eLhP5LWuUCGYe6pWc5MfQtnN5chfPRdIJYQ3NeTj4dgOPbcyPhyA0VU9j7GPZ7fdX25RmU_6T_psTpMPyTkbkuckkYCSJk97vFu1KsXW-ELJ5-HJWpyilQ2FPK86PA1p6D5ZgDu-rtx2ktt6fTX0tsxKgiSWpZeyKhV1p_6P5EFpK4J5yRfpVaec2puFALNGkMaWOLrZqG8B74lrjqRYTIL8HCCE9KqjoDfnugQSf9eVJaXmWdBngCLkD3tdneeuUGPGlK3iAP9bk2sw54GMKn-QhT5byn90qfawAFBr0jJ6pJZAlyTypSeRZBy7J4hRhcuplCfjd1QV1p9pCf9jglAKuS2BIbqAxq8EmA9LeHFH1EnL40WmJhK4',
//         'Accept': 'application/json'
//     }
// })
