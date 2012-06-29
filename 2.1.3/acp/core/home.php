<br /><br />

<div id="dashboard">

<div class="dash_box">
<div class="dash_box_top">Seiten &amp; Eintr&auml;ge</div>
<div class="dash_box_middle">
<ul>
<li><strong>Anzahl Seiten:</strong> <?=countPages();?></li>
<li><strong>Anzahl Eintr&auml;ge Aktiv:</strong> <?=countAllLinks();?></li>
<li><strong>Anzahl Neue Eintr&auml;ge:</strong> <?=countAllNewLinks();?></li>
<li><strong>Anzahl Kostenlose Eintr&auml;ge:</strong> <?=countFreeLinks();?></li>
<li><strong>Anzahl Premium Eintr&auml;ge:</strong> <?=countPremLinks();?></li>
</ul>
</div>
</div>


<div class="dash_box">
<div class="dash_box_top">Kategorien</div>
<div class="dash_box_middle">
<ul>
<li><strong>Anzahl Kategorien:</strong> <?=countAllCats();?></li>
<li><strong>Anzahl Haupt Kategorien:</strong> <?=countMaincat();?></li>
<li><strong>Anzahl Unterkategorien:</strong> <?=countSubcat();?></li>
<li><strong>Anzahl Kategorievorschl&auml;ge:</strong> <?=countCatOffer();?></li>
</ul>
</div>
</div>


<div class="dash_box">
<div class="dash_box_top">Werbebanner</div>
<div class="dash_box_middle">
<ul>
<li><strong>Anzahl Banner Gesamt:</strong> <?=countBanner();?></li>
<li><strong>Anzahl Banner Aktiv:</strong> <?=countAktivBanner();?></li>
<li><strong>Anzahl Banner Head:</strong> <?=countBannerHead();?></li>
<li><strong>Anzahl Banner Content:</strong> <?=countBannerContent();?></li>
</ul>
</div>
</div>


<div class="dash_box">
<div class="dash_box_top">Weiteres</div>
<div class="dash_box_middle">
<ul>
<li><strong>Seiten Name:</strong> <?=get_setting_data("name");?></li>
<li><strong>Aktiv Template Name:</strong> <?=get_aktiv_layout_data("layout_name");?></li>
<li><strong>Anzahl Besucher:</strong> <?=countUser();?></li>
<li><strong>Anzahl Newsletteradressen:</strong> <?=countNewsletter();?></li>
</ul>
</div>
</div>

<br clear="left" /><br />


<div class="dash_box">
<div class="dash_box_top">Neusten Eintr&auml;ge</div>
<div class="dash_box_middle">
<ul>
<?=get_last_10_newlinks(); ?></ul>
</div>
</div>


<div class="dash_box">
<div class="dash_box_top">Kategorievorschl&auml;ge</div>
<div class="dash_box_middle">
<ul>
<?=get_last_10_catoffer(); ?>
</ul>
</div>
</div>



<div class="dash_box">
<div class="dash_box_top">Newsletter</div>
<div class="dash_box_middle">
<ul>
<?=get_last_10_newsletter();?>
</ul>
</div>
</div>


<div class="dash_box">
<div class="dash_box_top">Letzten Besucher</div>
<div class="dash_box_middle">
<ul>
<?=get_last_10_counter();?>
</ul>
</div>
</div>

<br clear="left" /><br />

</div>