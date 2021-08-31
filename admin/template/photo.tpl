{combine_css path=$FACEDETECTOR_PATH|@cat:"admin/template/style.css"}

<h2>{$TITLE} &#8250; {'Edit photo'|translate} {$TABSHEET_TITLE}</h2>


<form action="{$F_ACTION}" method="post" id="catModify">
  <fieldset>
    <legend>{'Detect faces within this photo.'|translate}</legend>

    <p>
      <div align="center"> 
        <img src="{$SRC_IMG}" alt="{'Image Source'|translate}">
      </div>
    </p>

    <p>
      <input class="submit" type="submit" value="{'Save'|translate}" name="save_faceDetector">
    </p>
  </fieldset>
</form>