// Toggle for the hamburger menu 
function toggleMenu() {
	document.getElementsByClassName("navigation")[0].classList.toggle("responsive");
	document.getElementsByClassName("menu-icon")[0].classList.toggle("close")
}

// Automated copywrite year
var dates = new Date();
	document.getElementById("currentYear").innerHTML = dates.getFullYear();

// Load more reviews
const reviews = document.querySelectorAll('.review_card');
const loadMoreReviews = document.getElementById('loadMoreReviews');
let visible = 8;

function showReviews() {
	reviews.forEach((review, index) => {
		review.style.display = index < visible ? 'block' : 'none'; 

	});

	if (visible >= reviews.length) {
		loadMoreReviews.style.display = 'none';
	}
}

loadMoreReviews.addEventListener('click', () => {
	visible += 8;
	showReviews();
})

showReviews();
