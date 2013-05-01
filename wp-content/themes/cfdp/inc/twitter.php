<?php
        
        
function parse_feed($usernames, $limit, $show, $prefix_sub, $wedge, $suffix_sub) {
 
    $usernames = str_replace(" ", "+OR+from%3A", $usernames);
    $feed = "http://search.twitter.com/search.atom?q=from%3A" . $usernames . "&rpp=" . $limit;
    $feed = file_get_contents($feed);
    $feed = str_replace("&", "&", $feed);
    $feed = str_replace("<", "<", $feed);
    $feed = str_replace(">", ">", $feed);
    $clean = explode("<entry>", $feed);
    $amount = count($clean) - 1;
 
    for ($i = 1; $i <= $amount; $i++) {
 
    	$entry_close = explode("</entry>", $clean[$i]);
    	$clean_content_1 = explode("<content type=\"html\">", $entry_close[0]);
    	$clean_content = explode("</content>", $clean_content_1[1]);
    	$clean_name_2 = explode("<name>", $entry_close[0]);
    	$clean_name_1 = explode("(", $clean_name_2[1]);
    	$clean_name = explode(")</name>", $clean_name_1[1]);
    	$clean_uri_1 = explode("<uri>", $entry_close[0]);
    	$clean_uri = explode("</uri>", $clean_uri_1[1]);
 
    	// Make the links clickable and take care quote & apostrophe
 
    	$clean_content[0] = str_replace("&lt;", "<", $clean_content[0]); 
    	$clean_content[0] = str_replace("&gt;", ">", $clean_content[0]); 
    	$clean_content[0] = str_replace("&amp;", "&", $clean_content[0]); 
    	$clean_content[0] = str_replace("&quot;", "\"", $clean_content[0]);
    	$clean_content[0] = str_replace("&apos;", "'", $clean_content[0]);
 
    	echo $prefix_sub;
 
    	if ($show == 1) { 
    		echo  "<a href=\"" . $clean_uri[0] . "\" class=\"twitterlink\">@" . $clean_name[0] . "</a>" . $wedge; 
    	}
    	echo $clean_content[0];
    	echo $suffix_sub;
    }
}
echo $prefix;
parse_feed($usernames, $limit, $show, $prefix_sub, $wedge, $suffix_sub);
echo $suffix;
?>