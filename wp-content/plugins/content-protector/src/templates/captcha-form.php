<div class="passster-form" [PASSSTER_ID]>  
  <form id="password-form" method="post" autocomplete="off" action-xhr="[PASSSTER_CURRENT_URL]" target="_top">
    <h4>[PASSSTER_FORM_HEADLINE]</h4>
    <p>[PASSSTER_FORM_INSTRUCTIONS]</p>
    <fieldset>
	    <span class="passster-captcha">[PASSSTER_CAPTCHA_IMG]</span>
	    <span class="passster-captcha-input">
	    	<input type="text" placeholder="[PASSSTER_PLACEHOLDER]" tabindex="1" name="[PASSSTER_AUTH]" id="[PASSSTER_AUTH]">
	    	<button name="submit" type="submit" id="passster_submit" data-submit="...Checking Captcha">[PASSSTER_BUTTON_LABEL]</button>
		</span>
    </fieldset>
  </form>
</div>