public function up()
{
    Schema::table('payment_vouchers', function (Blueprint $table) {
        $table->date('date')->nullable()->after('payee_company');
    });
}

public function down()
{
    Schema::table('payment_vouchers', function (Blueprint $table) {
        $table->dropColumn('date');
    });
}
