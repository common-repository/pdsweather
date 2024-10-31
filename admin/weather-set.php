<?php
/**
 * Created by PhpStorm.
 * User: Iva
 * Date: 3.4.2015.
 * Time: 23:30
 */
$cntry = simplexml_load_file(WP_PLUGIN_DIR.'/pdsweather/admin/country.xml');

if(isset($_POST) && !empty($_POST)){
    foreach($_POST as $key=>$opt){
        update_option($key,$opt);
    }
}
$opt_name='weather-key';
$hidden_field_name = 'mt-hidden-key';
$opt_val = get_option( $opt_name );
//print_r(get_option('degrees'));
?>
<div class="wrap">
    <h2>Weather settings</h2>
    <form action="" method="post">
        <table class="form-table">
        <tr>
            <th><label>Api key: </label></th> <td><input type="text" name="weather-key" value="<?php echo $opt_val ?>"/> <br />
                In order to receive data please make your own API key on <a href="http://www.wunderground.com/weather/api?apiref=e53cbb9516ee4519">Weather underground</a></td>

        </tr>
        <tr>
            <th>Choose your country:</th><td>
                <select class="country" name="country">
                    <option value="">Select...</option>
                    <?php foreach($cntry->country as $ct){?>
                    <option value="<?php echo $ct->iso?>" <?php if(get_option('country')==$ct->iso) echo 'selected="selected"'?>><?php echo $ct->name?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
<!--            <tr><th>Zip:</th><td><input type="text" name="zip" class="zip" /></td></tr>-->
            <tr <?php if(!get_option('country')) echo 'class="hidden"'?>><th>What's your city?:<br /><small>Start writing first two letters of your city</small></th>
                <td><input class="city" type="text" name="city" value="<?php echo get_option('city')?>"/></td></tr>
        <tr <?php if(!get_option('country')) echo 'class="hidden"'?>><th>Set your location:</th><td><input class="ws" type="text" name="ws" value="<?php echo get_option('ws')?>"/>
                <input type="hidden" class="locid" name="locid" value="<?php echo get_option('locid')?>"/>
            </td></tr>
<!--        <tr><th>Set max number of requests per hour:</th><td><input type="text" name="times" value="--><?php //echo get_option('times')?><!--"/></td></tr>-->
            <tr><th>Use icon set:</th><td><input type="radio" name="iconset" value="0" <?php if(get_option('iconset')==0) echo "checked" ?>>No</input>
                    <input type="radio" name="iconset" value="1" <?php if(get_option('iconset')==1) echo "checked"?>>Yes</input>
                    <input type="radio" name="iconset" value="2" <?php if(get_option('iconset')==2) echo "checked"?>>Weather font</input>
                    <br/>
                    <select <?php if(get_option('iconset')!=1) echo 'class="hidden"' ?> name="icset">
                        <option value="0">Select WU icons</option>
                        <option value="a">Icon set #1</option>
                        <option value="b">Icon set #2</option>
                        <option value="c">Icon set #3</option>
                        <option value="d">Icon set #4</option>
                        <option value="e">Icon set #5</option>
                        <option value="f">Icon set #6</option>
                        <option value="g">Icon set #7</option>
                        <option value="h">Icon set #8</option>
                        <option value="i">Icon set #9</option>
                        <option value="j">Icon set #10</option>
                        <option value="k">Icon set #11</option>
                    </select>
                </td></tr>
            <tr><th>Show feels like:</th><td>
                    <input name="feelslike" type="radio" value="0" <?php if(get_option('feelslike')==0) echo "checked"?>>No</input>
                    <input name="feelslike" type="radio" value="1" <?php if(get_option('feelslike')==1) echo "checked"?>>Yes</input>
                </td>
            </tr>
            <tr>
                <th>Celsius or Fahrenheit?</th>
                <td>
                    <?php $degrees = get_option('degrees'); ?>
                    <input name="degrees[c]" class="degrees" type="checkbox" value="c" <?php if(isset($degrees['c']) && $degrees['c']=="c") echo "checked"?>>Celsius</input>
                    <input name="degrees[f]" class="degrees" type="checkbox" value="f" <?php if(isset($degrees['f']) && $degrees['f']=="f") echo "checked"?>>Fahrenheit</input>
                </td>
            </tr>
            <tr>
                <th>Show weather label</th>
                <td>
                    <input name="weather" type="radio" value="0" <?php if(get_option('weather')==0) echo "checked"?>>No</input>
                    <input name="weather" type="radio" value="1" <?php if(get_option('weather')==1) echo "checked"?>>Yes</input>
                </td>
            </tr>
            <tr>
                <th>Preview</th>
                <td>
                    <div class="img" <?php if(get_option('iconset')!=1) echo 'style="display:none;"'?>>
                        <img src="http://icons.wxug.com/i/c/a/partlycloudy.gif" alt="Partly cloudy"/>
                    </div>
                    <div class="wi wi-day-sunny-overcast" style="<?php if(get_option('iconset')!=2) echo "display:none;"?> font-size: 30px;"></div>
                    <div class="conditions">
                        <div class="label" <?php if(get_option('weather')==0) echo 'style="display:none"'?>>Partly sunny</div>
                        <div class="feelslike" <?php if(get_option('feelslike')==0) echo 'style="display:none"'?>><small>Feels like: <span class="f">66.3°F</span> <span class="c">19.1°C</span></small></div>
                        <div class="current"><span class="f">66.3°F</span> <span class="c">19.1°C</span></div>
                    </div>
                </td>
            </tr>
            <tr>
                <th></th><td><input type="submit" name="save" value="Save" class="button button-primary"></td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript">
    $j = jQuery.noConflict();

    $j(document).ready(function(e){

        var opt = <?php echo json_encode($_POST)?>;

//        console.log($j(opt).length);

        if($j(opt).length){
            if(opt.iconset==1){
                $j('select[name="icset"]').val(opt.icset);
            }

            if(opt.degrees.f){
                $j('.f').fadeIn()
            }else{
                $j('.f').fadeOut();
            }

            if(opt.degrees.c){
                $j('.c').fadeIn()
            }else{
                $j('.c').fadeOut();
            }
        }

    });

    $j('.country').on('change',function(e){
        if($j(this).val()){
            $j('.city').parents('tr.hidden').removeClass('hidden').fadeIn();
            $j('.ws').parents('tr.hidden').removeClass('hidden').fadeIn();

        }
    });

    function handle(data){
        var res = data.RESULTS;
        var html = '';

        if(res.length>0){
            $j.each(res,function(i,e){
//                console.log(e.l);
                html += '<a href="'+ e.l +'" class="loc button button-secondary">'+e.name+'</a>';
            });
            $j('.ws').parent().find('a').remove();
            $j('.ws').parent().append(html);
        }
    }

    $j('.city').on('keyup',function(e){

      $j('.ws').parents('tr.hidden').removeClass('hidden').fadeIn();

        var ct = $j(this).val();
        var ctr = $j('.country').val();
        if(ct.length>1){
        $j.ajax({
            crossDomain: true,
            url:"http://autocomplete.wunderground.com/aq?query="+ct+"&c="+ctr+"&cb=handle",
            type:'get',
            contentType: "application/json; charset=utf-8",
            dataType:'jsonp',
            success:function(s){
                console.log(s);
            }
        });
        }
    });

    $j('.ws').parent().on('click','.loc',function(e){
        e.stopPropagation();
        e.preventDefault();

        $j('.ws').val($j(this).text());
        $j('.locid').val($j(this).attr('href'));

        console.log($j(this).attr('href'));
        $j('.city').val($j(this).text());
    });

    $j('input[name="iconset"]').click(function(e){
        if($j(this).val()==1) {
            $j(this).parent().find('select').fadeIn();
            $j('.img').fadeIn();
            $j(this).parent().on('change', 'select', function (e) {
                var set = $j(this).val();

                if (set != 0) {
                    src = $j('.img img').attr('src', 'http://icons.wxug.com/i/c/' + set + '/partlycloudy.gif');
                }
//                console.log(set);
            });

        }
        if($j(this).val()==0){
            $j('.img').fadeOut();
            $j(this).parent().find('select').fadeOut();
        }

        if($j(this).val()==2){
            $j('.img').fadeOut();
            $j('.wi').fadeIn();
            $j(this).parent().find('select').fadeOut();


        }else{
            $j('.wi').fadeOut();
        }
    });

    $j('input[name="feelslike"]').click(function(e){
        if($j(this).val()==1){
            $j('.feelslike').fadeIn();
        }else{
            $j('.feelslike').fadeOut();
        }
    });

    $j('input[name="weather"]').click(function(e){
        if($j(this).val()==1){
            $j('.label').fadeIn();
        }else{
            $j('.label').fadeOut();
        }
    });

    $j('.degrees').click(function(e){

        var sel = '';
        $j('.degrees:checked').map(function(f){
            sel+=$j(this).val();
        });

        console.log(sel);

        if(sel=="c"){
            $j('.f').fadeOut();
            $j('.c').fadeIn();
        }

        if(sel=="f"){
            $j('.f').fadeIn();
            $j('.c').fadeOut();
        }

        if(sel=="cf"){
            $j('.f').fadeIn();
            $j('.c').fadeIn();
        }

        if(sel=''){
            $j('.f').fadeOut();
            $j('.c').fadeOut();
        }
    });

</script>