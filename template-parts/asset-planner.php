<?php
/* Trip planner */
?>
<div id="trip-planner">
	<div id="planner-header">
		<h1>Plan Your Trip</h1>
	</div>
	<div id="planner-body" class="clear">
		<form name="f" action="https://jump.trilliumtransit.com/redirect.php">
            <input type="hidden" name="sort" value="walk">
			<div class="form-row">
				<label for="saddr">From</label>
				<input type="text" name="saddr" id="saddr" placeholder="Address, landmark, or intersection" required="required">
				<button class="crosshair-icon" type="button" value="saddr"><?php get_svg_icon('crosshair', 'small'); ?><span>Use current location</span></button>
			</div>
			<div class="form-row">
				<label for="daddr">To</label>
				<input type="text" name="daddr" id="daddr" placeholder="Address, landmark, or intersection" required="required">
				<button class="crosshair-icon" type="button" value="daddr"><?php get_svg_icon('crosshair', 'small'); ?><span>Use current location</span></button>
			</div>
			<div id="default-settings">
				<div class="form-row clear">
					<div>Departing: <strong>Now</strong></div>
					<button type="button">Edit</button>
				</div>
			</div>
			<div id="additional-settings" class="hidden">
				<div class="form-row">
					<select class="form-control" name="ttype">
						<option value="dep">Leave at</option>
						<option value="arr">Arrive by</option>
					</select>
				</div>
				<div class="form-row">
					<label for="ftime" class="obscure screen-reader-text">Time</label>
					<input type="text" id="ftime" name="time" value="">
					<label for="fdate" class="obscure screen-reader-text">Date</label>
					<input type="text" id="fdate" name="date" value="">
				</div>
			</div>
			<button type="submit">Get Directions</button>
		</form>
	</div> <!-- end #planner-body -->
</div> <!-- end #trip-planner -->