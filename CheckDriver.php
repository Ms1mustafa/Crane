<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="sheard.js" defer></script>
  <script src="RequestesJs/Notification/createNotification.js" defer></script>
  <script src="RequestesJs/Test/getData.js" defer></script>
  <script src="RequestesJs/Test/addTestStatus.js" defer></script>
  <title>Document</title>
  <link rel="stylesheet" href="css/table.css?1999">

</head>

<body>


  <div class="heading">
    <h1>قائمة فحص المعدات المتنقلة <h1>
  </div>
  <div class="outer-wrapper">
    <div class="table-wrapper">

      <table>
        <label class="label">الاولوية : عالية </label>
        <thead>
          <th>الاجرائات الازمة</th>
          <th>مرفوض</th>
          <th>مقبول</th>
          <th>نوع الفحص </th>

        </thead>
        <tbody id="priority1">
          <!-- <tr>
            <td></td>
            <td><input type="radio" name="Accept"></td>
            <td><input type="radio" name="Accept"></td>
            <td>فحص الاطار الامامي </td>
          </tr>
          <tr>
            <td> </td>
            <td><input type="radio" name="B"></td>
            <td><input type="radio" name="B"></td>
            <td>فحص حزام الامان </td>
          </tr>
          <tr>
            <td> </td>
            <td><input type="radio" name="C"></td>
            <td><input type="radio" name="C"></td>
            <td>فحص المنبه الامامي والمنبه الحلفي</td>
          </tr>
          <tr>
            <td></td>
            <td><input type="radio" name="D"></td>
            <td><input type="radio" name="D"></td>
            <td> فحص المرايا </td>
          </tr>
          <tr>
            <td></td>
            <td><input type="radio" name="E"></td>
            <td><input type="radio" name="E"></td>
            <td>فحص المكابح </td>
          </tr>
          <tr>
            <td></td>
            <td><input type="radio" name="F"></td>
            <td><input type="radio" name="F"></td>
            <td>فحص الزجاج الامامي والفرشات </td>
          </tr> -->
        </tbody>
      </table>
      <br>
      <input type="checkbox"><label for="">اذا كان احد الفحوصات اعلاه مرفوض فتعتبر المعدة غير صالحة للعمل
        .</label>

    </div>
  </div>

  <div class="heading">
    <h1>قائمة فحص المعدات المتنقلة <h1>
  </div>
  <div class="outer-wrapper">
    <div class="table-wrapper">
      <table>
        <label class="label">الاولوية : متوسطة </label>
        <thead>
          <th>الاجرائات الازمة</th>
          <th>مرفوض</th>
          <th>مقبول</th>
          <th>نوع الفحص </th>
        </thead>
        <tbody id="priority2">
          <!-- <tr>
            <td></td>
            <td><input type="radio" name="Accept"></td>
            <td><input type="radio" name="Accept"></td>
            <td> فحص الاطار الخلفي</td>
          </tr>
          <tr>
            <td></td>
            <td><input type="radio" name="Accept"></td>
            <td><input type="radio" name="Accept"></td>
            <td>فحص مستوى زيت المحرك</td>
            
          </tr>
          <tr>
            <td></td>
            <td><input type="radio" name="Accept"></td>
            <td><input type="radio" name="Accept"></td>
            <td> فحص مستوى زيت الهايدرولك
            </td>
          </tr>
          <tr>
            <td></td>
            <td><input type="radio" name="Accept"></td>
            <td><input type="radio" name="Accept"></td>
            <td>فحص مستوى الماء
            </td>
          </tr>
          <tr>
            <td></td>
            <td><input type="radio" name="Accept"></td>
            <td><input type="radio" name="Accept"></td>
            <td>فحص الاضائة
            </td>
          </tr>
          <tr>
            <td></td>
            <td><input type="radio" name="Accept"></td>
            <td><input type="radio" name="Accept"></td>
            <td>فحص سلالم الصعود والجسم الخارجي
            </td>
          </tr>
          <tr>
            <td></td>
            <td><input type="radio" name="Accept"></td>
            <td><input type="radio" name="Accept"></td>
            <td>فحص التسريبات
            </td>
          </tr>
          <tr>
            <td></td>
            <td><input type="radio" name="Accept"></td>
            <td><input type="radio" name="Accept"></td>
            <td> فحص البطاريات
            </td>
          </tr>
          <tr>
            <td></td>
            <td><input type="radio" name="Accept"></td>
            <td><input type="radio" name="Accept"></td>
            <td>فحص مستوى الوقود</td>
          </tr>
          <tr>
            <td></td>
            <td><input type="radio" name="Accept"></td>
            <td><input type="radio" name="Accept"></td>
            <td>فحص سيور المحرك</td>
          </tr> -->

        </tbody>
      </table>
      <br>
      <input type="checkbox"><label for="">اذا كان احد الفحوصات اعلاه غير مرفوض .</label>

    </div>
  </div>


  <div class="heading">
    <h1>قائمة فحص المعدات المتنقلة <h1>
  </div>
  <div class="outer-wrapper">
    <div class="table-wrapper">
      <table>
        <label class="label">الاولوية : منخفضة H</label>

        <thead>
          <th>الاجرائات الازمة</th>
          <th>مرفوض</th>
          <th>مقبول</th>
          <th>نوع الفحص </th>

        </thead>
        <tbody id="priority3">
        </tbody>
      </table>
      <br>
      <input type="checkbox"><label for="">اذا كان احد الفحوصات اعلاه غير
        مرفوض .</label>

    </div>
  </div>
  <br>
  <br>
  <br>
  <div class="buttonDriver">
    <div>
      <button class="btn-reqDriver" id="submitBtn">Subment </button>



    </div>

</body>

</html>

</div>
</section>
</body>

</html>