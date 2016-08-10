<?php $search_text = "Søg på siden..."; ?>
<form method="get" id="searchform"
action="<?php bloginfo('home'); ?>/">
<input
	type="search"
  placeholder="<?php echo $search_text; ?>"
	name="s"
	id="s"
/>
<input type="hidden" id="searchsubmit" />
</form>