

<link rel="stylesheet" type="text/css" href="{{asset('news/css/demo-page-styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('news/css/breaking-news-ticker.css')}}">
<?php 

?>

<style type="text/css">
    @media (max-width: 600px){
        .bn-controls {
            display: none;
        }
        .bn-news{
            right: 0px!important
        }
    }                    
</style>
<div class="demo-section-box" >
    <div class="section-container" >
        <div class="demo-box" >

            <div class="breaking-news-ticker" id="newsTicker2" style="background-color: #fff;!important;z-index: 9;">

                <div class="bn-news"   >
                    <ul  >
                    <?php $x =' <li> <a style="color:red;font-size:25px" href="">  ذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص</a> </li>' ?>
                        {!! $x  !!}
                   
                    <li>&nbsp;<img width="20px" src="{{asset('images\logo.png')}}">&nbsp;</li>
                    <?php $x =' <li> <a style="color:red;font-size:25px" href="">  ذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص</a> </li>' ?>
                        {!! $x  !!}
                   
                    <li>&nbsp;<img width="20px" src="{{asset('images\logo.png')}}">&nbsp;</li>
                   
                    </ul>
                </div>
                <div class="bn-controls">
                    <button><span class="bn-arrow bn-prev"></span></button>
                    <button><span class="bn-action"></span></button>
                    <button><span class="bn-arrow bn-next"></span></button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!--<script src="js-n/jquery-2.2.4.min.js"></script>-->
<script src="{{asset('news/js/breaking-news-ticker.min.js')}}"></script>

<!--<script src="js-n/popper.min.js" type="text/javascript"></script>-->
<!--<script src="js-n/bootstrap.min.js" type="text/javascript"></script>-->
<script src="{{asset('news/js/breaking-news-ticker.min.js')}}"></script>
<!-- <script type="text/javascript" src="slick/js/slick.min.js"></script> -->
@if( Session::get('locale') == 'ar')
        <script type="text/javascript">
    jQuery(document).ready(function($){
        $('#newsTicker2').breakingNews({
            direction: 'rtl'
        });

    });
</script>
@else
   <script type="text/javascript">
       jQuery(document).ready(function($){
           $('#newsTicker2').breakingNews({
               direction: 'ltr'
           });

       });
   </script>
@endif