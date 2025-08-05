@php
    $contents = $event->contents;

    $gender = $recipient->memberGender->name;
    $name = $recipient->firstname . ' ' . $recipient->lastname;
    $title_event = $event->title;
    $photo = '<img class="banner" src="'. asset($event->event_img) .'" alt="Event Banner" onerror="this.style.display=none;">';
    $cluster = $event->cluster->name  ?? 'N/A';
    $date = \Carbon\Carbon::parse($event->date)->format('F d, Y');
    $time = '<span>'. \Carbon\Carbon::parse($event->start_time)->format('h:i A') .'-'. \Carbon\Carbon::parse($event->end_time)->format('h:i A') .'</span>';
    $venue = $event->location;
    $invitation_letter ='<a href="'.asset(\App\Models\Custom\EventInvite::getInvitationUrl($event->id, $recipient->agency)) .'" download>Invitation Letter</a>';
	$link_invitation = route('events.view', $event->id);
    $qrcode_invitation = QrCode::size(200)->generate(route('events.view', $event->id));

	
	// FOR ATTACHMENTS
	$attachments = json_decode($event->attachments, true);

    $other_materials ='
		<ul>';
			
			if (!empty($attachments)){
				foreach ($attachments as $index => $file){
					$other_materials .='
						<li>
							<a class="text-primary" href="'. asset($file) .'" target="_blank" download>
								Attachment '. $index + 1 .' : '. basename($file) .'
							</a>
						</li>
					';
				}
			}

	$other_materials .='
		</ul>';


	// FOR ATTACHMENTS
	$other_links = json_decode($event->other_links, true);

    $link_other_materials ='
		<ul>';
			
			if (!empty($other_links)){
				foreach ($other_links as $index => $file){
					$link_other_materials .='
						<li>
							<a class="text-primary" href="'. asset($file) .'" target="_blank" download>
								Link '. $index + 1 .' : '. $file .'
							</a>
						</li>
					';
				}
			}

	$link_other_materials .='
		</ul>';
	

    $keywords   = ['{gender}','{name}','{title_event}','{photo}','{cluster}','{date}','{time}','{venue}','{invitation_letter}','{other_materials}','{link_other_materials}','{qrcode_invitation}','{link_invitation}'];
    $variables  = [$gender, $name, $title_event, $photo, $cluster, $date, $time, $venue, $invitation_letter, $other_materials, $link_other_materials, $qrcode_invitation, $link_invitation];
    $contents = str_replace($keywords, $variables, $contents);
@endphp

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<title>PLLO Event Invitation</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<style>
			{!! $event->styles !!}
		</style>
	</head>
	<body>
		{!! $contents !!}
	</body>
</html>
