<script type="text/template" id="wpb-onoff-tmpl">
	<form id="wpb-onoff-form">
	<table class="form-table">
		<tr>
			<th><label for="onoff-status">Enable:</label></th>
			<td><input type="checkbox" id="onoff-status" name="status" <%- status === 'on' ? 'checked' : '' %>/></td>
		</tr>
		<tr>
			<th><label for="onoff-links">Disable Links:</label></th>
			<td><input type="checkbox" id="onoff-links" name="links" <%- links === 'on' ? 'checked' : '' %>/></td>
		</tr>
		<tr>
			<th><label for="onoff-dashboard">On Dashboard:</label></th>
			<td>
				<input type="checkbox" id="onoff-dashboard" name="dashboard" <%- dashboard === 'on' ? 'checked' : '' %>/>
				<p class="description">Enable on Dashboard ? </p>
			</td>
		</tr>
		<tr>
			<th><label for="onoff-notice">Show Notice:</label></th>
			<td>
				<input type="checkbox" id="onoff-notice" name="notice" <%- notice === 'on' ? 'checked' : '' %>/>
				<p class="description">Click Demo for preview</p>
			</td>
		</tr>
		<tr class="<%- notice ? '' : 'pb-hidden' %>">
			<th><label for="onoff-theme">Theme:</label></th>
			<td>
				<select name="theme" id="onoff-theme">
					<option value="chrome" <%- theme === 'chrome' ? 'selected' : '' %>>Light</option>
					<option value="chrome-indicator"<%- theme === 'chrome-indicator' ? 'selected' : '' %>>Light Indicator</option>
					<option value="dark" <%- theme === 'dark' ? 'selected' : '' %>>Dark</option>
					<option value="dark-indicator" <%- theme === 'dark-indicator' ? 'selected' : '' %>>Dark Indicator</option>
				</select>
			</td>
		</tr>
		<tr class="<%- notice ? '' : 'pb-hidden' %>">
			<th><label for="onoff-language">Language:</label></th>
			<td>
				<select id="onoff-language" name="language">
					<option value="english" <%- language === 'english' ? 'selected' : '' %>>English</option>
					<option value="portuguese" <%- language === 'portuguese' ? 'selected' : '' %>>Portuguese</option>
					<option value="spanish" <%- language === 'spanish' ? 'selected' : '' %>>Spanish</option>
				</select>
			</td>
		</tr>
	</table>
	<button class="button button-primary">Save Changes</button>
	</form>
</script>