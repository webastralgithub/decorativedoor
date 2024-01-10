<div style="width: 80%; margin: 20px auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px; overflow: hidden;">
    <div style="padding: 20px;">
        <div style="margin-bottom: 30px;">
            <p style="margin-bottom: 10px; font-size: 16px; line-height: 1.5;">Hello, this is the content of my email!</p>
            <p style="margin-bottom: 10px; font-size: 16px; line-height: 1.5;">Title: {{ $emailData['title'] }}</p>
            <p style="margin-bottom: 10px; font-size: 16px; line-height: 1.5;">Price: {{ $emailData['price'] }}</p>
            <p style="margin-bottom: 10px; font-size: 16px; line-height: 1.5;">Description: {!! $emailData['description'] !!}</p>
            @if(!empty($emailData['selectvarient']) && $emailData['selectvarient'] != 'Select Size')
                <p style="margin-bottom: 10px; font-size: 16px; line-height: 1.5;">Variant: {{ $emailData['selectvarient'] }}</p>
            @else
                <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Variants name</th>
                    </tr>
                    @foreach($emailData['variants'] as $variants)
                        <tr>
                            <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">{{ $variants->name }}</td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>
</div>
