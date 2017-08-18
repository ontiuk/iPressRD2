<form role="search" method="get" id="searchform" class="search-box" action="<?= esc_url( home_url('/') ); ?>">
	<div class="form-group has-feedback">
		<input type="text" class="form-control" type="search" name="s" placeholder="<?= __( 'Search', 'maxi' ); ?>">
		<i class="fa fa-search form-control-feedback" id="search-submit" role="button"></i>
	</div>
</form>
