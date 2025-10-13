/**
 * Agenda Tabs Navigation
 * Handles tab switching for schedule tables
 */

document.addEventListener('DOMContentLoaded', function() {
	// Get all tab buttons
	const tabButtons = document.querySelectorAll('.agenda-tab-btn');
	
	if (tabButtons.length === 0) {
		return; // No tabs on this page
	}
	
	// Add click event to each button
	tabButtons.forEach(function(button) {
		button.addEventListener('click', function() {
			const targetTab = this.getAttribute('data-tab');
			
			// Remove active class from all buttons
			tabButtons.forEach(function(btn) {
				btn.classList.remove('active');
			});
			
			// Add active class to clicked button
			this.classList.add('active');
			
			// Hide all tab panes
			const tabPanes = document.querySelectorAll('.agenda-tab-pane');
			tabPanes.forEach(function(pane) {
				pane.classList.remove('active');
			});
			
			// Show target tab pane
			const targetPane = document.getElementById(targetTab);
			if (targetPane) {
				targetPane.classList.add('active');
			}
		});
	});
});

