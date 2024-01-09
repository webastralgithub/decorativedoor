<!-- resources/views/emails/my-email.blade.php -->
<p>Hello, this is the content of my email!</p>

<p>Title :- {{$emailData['title']}}</p>
<p>Price :- {{$emailData['price']}}</p>
<p>Description :- {{$emailData['description']}}</p>
@if(!empty($emailData['selectvarient']) && $emailData['selectvarient'] != 'Select Size')
<p>Variant :- {{$emailData['selectvarient']}}</p>
@else
<table>
    <tr>
        <td>variants name</td>
    </tr>
@foreach($emailData['variants'] as $variants)

    <tr>
        <td>{{$variants->name}}</td>
    </tr>

@endforeach
</table>
@endif

