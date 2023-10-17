<x-mail::message>
# Hi, {{ $loan_application->barrower->name }}

Your Loan Request with the following details has been approved by {{ $loan_application->lender->name }}.

Loan Amount: **PHP {{ $loan_application->loan_amount }}**  
Terms: **{{ $loan_application->terms }} {{ $loan_application->term_unit }}**  
Monthly Payment: **PHP {{ $loan_application->monthly_payment }}**  

<x-mail::button url="http://facebook.com" color="primary">
Send Payment
</x-mail::button>


<x-mail::table>
| Laravel        | Table         | Example  |
| :------------- |:-------------:| --------:|
| Col 2 is       | Centered      | $10      |
| Col 3 is       | Right-Aligned | $20      |
</x-mail::table>
<x-mail::subcopy>
***This is an automatically generated email, please do not reply***
</x-mail::subcopy>
<x-mail::footer>
Unsubscribe
</x-mail::footer>
</x-mail::message>
