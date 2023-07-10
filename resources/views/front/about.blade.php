@extends('layouts.front')
@section('title','About KathakBeats - Classical Dance Academy')
@section('description','KathakBeats is founded by Siddharth R Prabhu and Sanika Prabhu, who is a disciple of Pt. Vasantrao Ghadge , Taalmani Mukundraj Deo & Smt. Harshada Jambekar.')
@section('content')
<main>
	<section class="about-kathakbeats" data-sec="kathakbeats" id="kathakbeats">
		<div class="container">
			<h2 class="no-border">About Us</h2>
			<div class="row">
				<div class="col-lg-4">
					<p>
						KathakBeats is founded by Siddharth R Prabhu and Sanika Prabhu, who is a disciple of Pt. Vasantrao Ghadge , Taalmani Mukundraj Deo & Smt. Harshada Jambekar.
					</p>
					<p>
						It is a Classical Dance Academy which offers Regular Training , Workshops and other modules of training in KATHAK in both online  and studio class modes  for all the dance enthusiasts.
					</p>
					<p>
						Based in Mumbai, it has taught Kathak to over 800+ Students in the past 3 Years of its Inception. 
					</p>
					<p>
						Kathak Beats is led by Sanika Prabhu and supported by a strong team of able artists : 
					</p>
				</div>
				<div class="col-lg-4 offset-lg-1 right-content">
					<p>
						Radhika Joshi,  Samiksha Malankar and Anushka Ghag who have all completed their Nritya Visharad in Kathak and are nationally accredited artists.
					</p>
					<p>
						Over the years of learning, teaching and breathing Kathak, Sanika has dreamt of being able to teach and reach a greater number of audiences by establishing a platform for those who share the same love and passion to express the art form of Kathak.
					</p>
					<p>
						KathakBeats has been associated with <br>classical training and choreographies with various schools, colleges, social events and corporates.
					</p>
				</div>
			</div>
		</div>
	</section>

	<section class="kathabeats-team" data-sec="about-team" id="about-team">
		<div class="container">
			<h2 class="no-border">Our Team</h2>
			<div class="team-wrapper">
				
				<div class="team-outer">
					<div class="team-inner">
						<div class="thumb" style="background-image: url({{ asset('front/images/team/sanika_purohit_prabhu.png')  }});"></div>
						<div class="team-info">
							<h6>Ms. Sanika Purohit Prabhu</h6>
							<p>Founder</p>
							<a href="#" class="fancy-link" title="Learn more" data-team="sanika">Learn more</a>
						</div>
					</div>
				</div>

				<div class="team-outer">
					<div class="team-inner">
						<div class="thumb" style="background-image: url({{ asset('front/images/team/siddharth_prabhu.png')  }});"></div>
						<div class="team-info">
							<h6>Mr. Siddharth R Prabhu</h6>
							<p>Co-Founder</p>
							<a href="#" class="fancy-link" title="Learn more" data-team="siddharth">Learn more</a>
						</div>
					</div>
				</div>

				<div class="team-outer">
					<div class="team-inner">
						<div class="thumb" style="background-image: url({{ asset('front/images/team/radhika_joshi.png')  }});"></div>
						<div class="team-info">
							<h6>Radhika Joshi</h6>
							<p>Faculty</p>
							<a href="#" class="fancy-link" title="Learn more" data-team="radhika">Learn more</a>
						</div>
					</div>
				</div>

				<div class="team-outer">
					<div class="team-inner">
						<div class="thumb" style="background-image: url({{ asset('front/images/team/samiksha_malankar.png')  }});"></div>
						<div class="team-info">
							<h6>Samiksha Malankar</h6>
							<p>Faculty</p>
							<a href="#" class="fancy-link" title="Learn more" data-team="samiksha">Learn more</a>
						</div>
					</div>
				</div>

				<div class="team-outer">
					<div class="team-inner">
						<div class="thumb" style="background-image: url({{ asset('front/images/team/anushka_ghag.png')  }});"></div>
						<div class="team-info">
							<h6>Anushka Ghag</h6>
							<p>Faculty</p>
							<a href="#" class="fancy-link" title="Learn more" data-team="anushka">Learn more</a>
						</div>
					</div>
				</div>	 

				<div class="team-outer">
					<div class="team-inner">
						<div class="thumb" style="background-image: url({{ asset('front/images/team/shalmali_zankar.png')  }});"></div>
						<div class="team-info">
							<h6>Shalmali Zankar</h6>
							<p>Faculty</p>
							<a href="#" class="fancy-link" title="Learn more" data-team="shalmali">Learn more</a>
						</div>
					</div>
				</div>

				<div class="team-outer">
					<div class="team-inner">
						<div class="thumb" style="background-image: url({{ asset('front/images/team/nutan_surve.png')  }});"></div>
						<div class="team-info">
							<h6>Nutan Surve</h6>
							<p>Head of Operations</p>
							<a href="#" class="fancy-link" title="Learn more" data-team="Nutan">Learn more</a>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</section>


	<div class="member-detail-wrapper custom-scroll" data-team-detail="sanika">
		<div class="inner-content">
			<a href="#" class="close-team" title="Close"><img src="{{ asset('front/images/close.svg') }}" alt=""></a>
			<h3>Ms. Sanika Purohit Prabhu <span>Founder</span></h3>
			<p>
				Nritya Visharad Sanika Prabhu is  a disciple of Kathak Guru Pt. Vasantrao Ghadge, Taalmani Pt. Mukundraj Deo & Mrs. Harshada Jambekar. She has completed Nritya-Visharad in Kathak from Akhil Bharatiya Gandharva University.
			</p>
			<p>
				She has  been Awarded as "Nritya Pratibha" at "9th Cuttack International Dance Festival, Orissa in 2018 and with “Goregaon Gaurav Puraskar” in 2010.
			</p>
			<p>
				She is also engaged as a Kathak Artist Performer in the epic saga, “Mughal-e-Azam"(The Musical Play) directed by Mr. Feroz Abbas Khan & choreographed by Ms. Mayuri Upadhya which has completed more than 180+ Shows in  Mumbai, Ahmedabad, Singapore, Dubai till date. 
			</p>
			<p>
				She has also had the privilege to perform at various dance festivals namely Girnar Mahotsav, Natyanjali Festival and Samsara Festival. 
			</p>
			<p>
				With respect to her academic qualification she has completed her  L.L.B (Gen) and Masters in Commerce from Mumbai University. She has completed her graduation from Narsee Monjee College of Commerce and Economics, Mumbai.
			</p>
		</div>
	</div>

	<div class="member-detail-wrapper custom-scroll" data-team-detail="siddharth">
		<div class="inner-content">
			<a href="#" class="close-team" title="Close"><img src="{{ asset('front/images/close.svg') }}" alt=""></a>
			<h3>Mr. Siddharth R Prabhu<span>Co Founder</span></h3>
			<p>
				Mr. Siddharth R Prabhu is a Chartered Accountant and holds a Bachelors degree in Law & Commerce. He has over 5 Years of Experience in the fields of Audit & Taxation with a strong pedigree in financial and business management. 
			</p>
			<p>
				He heads the management of the non-creative of the brand mainly relating to the operations, media, marketing, finance and technology.
			</p>
		</div>
	</div>

	<div class="member-detail-wrapper custom-scroll" data-team-detail="radhika">
		<div class="inner-content">
			<a href="#" class="close-team" title="Close"><img src="{{ asset('front/images/close.svg') }}" alt=""></a>
			<h3>Radhika Joshi <span>Faculty</span></h3>
			<p>
				Nritya Visharad Radhika Joshi, a Disciple of Guru Pt Vasantrao Ghadge ji and Mrs. Harshada Jambekar, who also holds a Bachelors degree in Economics from Mumbai University. 
			</p>
			<p>
				She has over 10 Years of Experience in Learning the art form of Kathak and has performed solo as well as along with her Guru at numerous events over the years including The Girnar Mahotsav, The Samsara Festival and across events for Incredible India.
			</p>
			<p>
				At Kathak Beats Radhika shoulders the responsibility of conducting regular online batches and online workshops to over 150+ Students. 
			</p>
		</div>
	</div>

	<div class="member-detail-wrapper custom-scroll" data-team-detail="samiksha">
		<div class="inner-content">
			<a href="#" class="close-team" title="Close"><img src="{{ asset('front/images/close.svg') }}" alt=""></a>
			<h3>Samiksha Malankar<span>Faculty</span></h3>
			<p>
				Nritya Visharad Samiksha Malankar is a Disciple of Guru Mrs Harshada Jambekar and holds a Bachelors degree in Psychology from Mumbai University. 
			</p>
			<p>
				She has over 8 Years of Experience in Learning the art form of Kathak and has performed at numerous events over the years including The Girnar Mahotsav, The Samsara Festival,  and Incredible India.
			</p>
			<p>
				At Kathak Beats Samiksha  is primarily vested with the conduct of Online Regular Kathak Classes along with Semi Classical Online Workshops.
			</p>
		</div>
	</div>

	<div class="member-detail-wrapper custom-scroll" data-team-detail="anushka">
		<div class="inner-content">
			<a href="#" class="close-team" title="Close"><img src="{{ asset('front/images/close.svg') }}" alt=""></a>
			<h3>Anushka Ghag<span>Faculty</span></h3>
			<p>
				A talented and creative artist with 13+ years of training in a classical dance form, Kathak. Highly motivated and an ambitious dancer, also been trained in other non-classical dance forms like Hip-hop, Bollywood, Jazz Funk and Waacking.
			</p>
			<p>
				Been a Member of KathakBeats since its inception and have been training more than 100+ students under them 
			</p>
			<p>
				Have been receiving training for various styles under the able guidance of following teachers:
			</p>
			<p>
				For Kathak : Guru Harshada Jambekar.
			</p>
			<p>
				For Bollywood : Aadil Khan and Krutika Solanki.
			</p>
			<p>
				For Jazz Funk and Hip-hop : Iraa Khanna and James Hiwale. 
			</p>
			<p>
				For Waacking : Chow En Lai.
			</p>
			<p>
				Have performed and presented at various prestigious platforms , festivals and been an acclaimed winner at renowned events conducted by College (PAN INDIA LEVEL)
			</p>
		</div>
	</div>

	<div class="member-detail-wrapper custom-scroll" data-team-detail="shalmali">
		<div class="inner-content">
			<a href="#" class="close-team" title="Close"><img src="{{ asset('front/images/close.svg') }}" alt=""></a>
			<h3>Shalmali Zankar<span>Faculty</span></h3>
			<p>
				Shalmali has trained extensively in Kathak for the past 20 years under the expertise of Guru Manisha Jeet. With many awards and honours such as the CCRT scholarship by the Ministry of Culture and Kalanaipunya Puraskar by Uttung Pratishthan under her belt, she aspires to find her expression in her practice. Being an avid reader with an extreme passion for theatre, she hopes to bring about a confluence of these in her dance. She has been dabbling with choreography and spatial design. She has recently begun developing her pedagogical practice, framing and reframing the ecology of dance to accommodate changing ideas and embrace cultural values. 
			</p>
		</div>
	</div>

	<div class="member-detail-wrapper custom-scroll" data-team-detail="Nutan">
		<div class="inner-content">
			<a href="#" class="close-team" title="Close"><img src="{{ asset('front/images/close.svg') }}" alt=""></a>
			<h3>Nutan Surve<span>Head of Operations</span></h3>
			<p>
				Ms. Nutan Surve is a performance driven and passionate Entrepreneur with 5+ years' experience working in and leading venture on corporate gifting. Worked with major corporate clients throughout Maharashtra. Dabbled in business development. 
			</p>
			<p>
				She holds a Bachelor's degree in Life science and Diploma in Materials Management. 
			</p>
			<p>
				She has been a part of Kathakbeats for more than 6 years and has been training under able guidance of Mrs. Sanika Prabhu, pursuing her degree under the Akhil Bhartiya Gandharva Mahavidyalaya University.
			</p>
			<p>
				She heads and manages the operational activities of the Brand and academy.
			</p>
		</div>
	</div>

</main>
@endsection	