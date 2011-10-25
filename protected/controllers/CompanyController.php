<?php
class CompanyController extends Controller
{
	public function actionIndex()
	{
		$objCompany = new AlibabaCompany();
		$objCompany->getCompanyUrl('http://search.china.alibaba.com/company/c-1032600_n-y.html', '');
	}
	
	public function actionTest()
	{
		$objFetch = new CFetch();
		$str = $objFetch->readUrl('http://www.google.com');
		
		echo $str;
	}
}
?>