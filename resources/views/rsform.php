<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">

  var dependents = new Array();
  
  dependents["s10"] = new Array("s21");
  dependents["s11"] = new Array("s20");
  dependents["s12"] = new Array("s41");
  dependents["s13"] = new Array("s32");
  dependents["s14"] = new Array();
  dependents["s15"] = new Array("s46");
  dependents["s16"] = new Array();
  dependents["s17"] = new Array();

  dependents["s20"] = new Array("s11");
  dependents["s21"] = new Array("s10");
  dependents["s22"] = new Array("s33");
  dependents["s23"] = new Array();
  dependents["s24"] = new Array("s35","s45");
  dependents["s25"] = new Array();
  dependents["s26"] = new Array("s37","s47");
  dependents["s27"] = new Array();
  
  dependents["s30"] = new Array("s40");
  dependents["s31"] = new Array();
  dependents["s32"] = new Array("s13");
  dependents["s33"] = new Array("s22");
  dependents["s34"] = new Array();
  dependents["s35"] = new Array("s45","s24");
  dependents["s36"] = new Array();
  dependents["s37"] = new Array("s26","s47","s44");
  
  dependents["s40"] = new Array("s30");
  dependents["s41"] = new Array("s12");
  dependents["s42"] = new Array();
  dependents["s43"] = new Array();
  dependents["s44"] = new Array("s37");
  dependents["s45"] = new Array("s24","s35");
  dependents["s46"] = new Array("s15");
  dependents["s47"] = new Array("s26","s37");
 
  dependents["p1s10"] = new Array("s35","s45");
  dependents["p1s20"] = new Array("s46");
  dependents["p2s10"] = new Array("s34");
  dependents["p2s20"] = new Array("s37","s47");
  
  var substitutes = new Array();
  
  substitutes["s10"] = new Array("a7");
  substitutes["s11"] = new Array("a3");
  substitutes["s12"] = new Array("a2");
  substitutes["s13"] = new Array("a6");
  substitutes["s14"] = new Array("b6");
  substitutes["s15"] = new Array("b7");
  substitutes["s16"] = new Array();
  substitutes["s17"] = new Array();

  substitutes["s20"] = new Array("a3");
  substitutes["s21"] = new Array("a7");
  substitutes["s22"] = new Array("a1");
  substitutes["s23"] = new Array();
  substitutes["s24"] = new Array("b2");
  substitutes["s25"] = new Array("b0");
  substitutes["s26"] = new Array("b1","b3");
  substitutes["s27"] = new Array();

  substitutes["s30"] = new Array("a4");
  substitutes["s31"] = new Array("a5");
  substitutes["s32"] = new Array("a6");
  substitutes["s33"] = new Array("a1");
  substitutes["s34"] = new Array("b8");
  substitutes["s35"] = new Array("b2");
  substitutes["s36"] = new Array("b5");
  substitutes["s37"] = new Array("b1","b3","b4");

  substitutes["s40"] = new Array("a4");
  substitutes["s41"] = new Array("a2");
  substitutes["s42"] = new Array("a8");
  substitutes["s43"] = new Array("a0");
  substitutes["s44"] = new Array("b4");
  substitutes["s45"] = new Array("b2");
  substitutes["s46"] = new Array("b7");
  substitutes["s47"] = new Array("b1","b3");
  
  $(document).ready(function () 
  {
    initForm();
    //clearForm();

    // Event-Listener für Tabs
    $("a.tab").click(function (e) 
    {
      e.preventDefault();
      $(".active").removeClass("active");
      $(this).addClass("active");
      $(this).parent().addClass("active");

      clearForm();

      $('.pfach1').hide();
      $('.pfach2').hide();
      $('.efach').hide();      
      
      if($(this).attr("title")=="pfach1")
      {
        $('.pfach1').show();
        $('#p1s10,#p1s20,#p2s10,#p2s20,#s10,#s20').attr('checked','checked');
	      $('#subA option[value="a0"],#subB option[value="b0"]').attr('selected','selected');
	      $('#a,#b').attr('value','2');
	      $('#apfach').attr('value','0');
        $('#p5').attr('value','pfach1');
      }
      else if($(this).attr("title")=="pfach2")
      {
        $('.pfach2').show();
        $("#p1s10,#p1s20,#p2s10,#p2s20,#s10,#s20").attr('checked','checked');
	      $('#subA option[value="a1"],#subB option[value="b1"]').attr('selected','selected');
	      $('#a,#b').attr('value','2');
	      $('#apfach').attr('value','0');
	      $('#p5').attr('value','pfach2');
      }
      else
      {
        $('.efach').show();
        $("#p1s10,#p1s20,#p2s10,#p2s20").attr('checked','checked');
        $('#p5').attr('value','efach');
	      $('#apfach').attr('value','1');
      }
      
      updateForm();
    })
    
    // Event-Listener für Radio-Buttons
    $('input[name="form[s1]"]').change(function () {
        updateForm();
    })

    $('input[name="form[s2]"]').change(function () {
        updateForm();
    })

    $('input[name="form[s3]"]').change(function () {
        updateForm();
    })

    $('input[name="form[s4]"]').change(function () {
        updateForm();
    })
    
  })
  
  function initForm()
  {
      var split_at = '.radio';
      $(split_at).each(function() {
          $(this).add($(this).nextUntil(split_at)).wrapAll("<div class='cell'/>");
      });
    
      $('input[type=radio][id$="0"], input[type=radio][id$="1"], input[type=radio][id$="2"], input[type=radio][id$="3"]').parent().addClass("A");
      $('input[type=radio][id$="4"], input[type=radio][id$="5"], input[type=radio][id$="6"], input[type=radio][id$="7"]').parent().addClass("B");
      $('input[type=radio][id$="4"], input[type=radio][id$="5"], input[type=radio][id$="6"], input[type=radio][id$="7"]').attr('elf','B');
      $('#p1s10,#p1s20,#p2s10,#p2s20').parent().addClass("span8").removeClass("A");
      $('#s16').remove(); $('#s17').remove(); $('#s23').remove(); $('#s27').remove();
    
      $('.pfach1').hide();
      $('.pfach2').hide();
      $('.efach').show();
      $('#p5').attr('value','efach');
      $("#p1s10,#p1s20,#p2s10,#p2s20").attr('checked','checked');
      $('#apfach').attr('value','1');
  }
  
  
  function updateForm()
  {
     var a = 0; var b = 0; var apfach = 0;
     
     // Radio-Buttons
     $("input[type=radio]:disabled").removeAttr('disabled');
     $("input[type=radio]:checked").each(function() {
	 if($(this).parent().is(":visible")){
             if($(this).attr('elf')=="A") { a++; apfach++; }
	     if($(this).attr('elf')=="B") b++;
             $.each(dependents[$(this).attr('id')], function(index, value) {
                 $("#" + value).attr('disabled', 'disabled');
             })
	 }
     })
     
     if($("#p5").attr('value')=="efach")
     {
       $("#a").attr('value', a);
       $("#b").attr('value', b);
     }
     else
     {
       $("#apfach").attr('value', apfach);
     }
  
     // Select-Listen
     $("option:disabled").removeAttr('disabled');
     $("input[type=radio]:checked").each(function() {
	 if($(this).parent().is(":visible")){
	     $.each(substitutes[$(this).attr('id')], function(index, value) {
                 $("option[value=" + value + "]").attr('disabled', 'disabled');             
		 if(value==$("#subA option:selected").val())
		     $("#subA option:selected").removeAttr('selected');
		 if(value==$("#subB option:selected").val())
		     $("#subB option:selected").removeAttr('selected');
	     })
	 }
     })
 }
 
 function clearForm() {
    $("input[type=radio]").removeAttr('disabled');
    $("input[type=radio]").removeAttr('checked');
    $("option").removeAttr('disabled');
    $("option").removeAttr('selected');    
    $(".formError").removeClass("formError").addClass("formNoError");
 }

</script>
