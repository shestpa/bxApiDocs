<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/catalog/general/price.php");

/***********************************************************************/
/***********  CPrice  **************************************************/
/***********************************************************************/

/**
 * 
 *
 *
 *
 *
 * @return mixed 
 *
 * @static
 * @link http://dev.1c-bitrix.ru/api_help/catalog/classes/cprice/index.php
 * @author Bitrix
 */
class CPrice extends CAllPrice
{
	
	/**
	 * <p>Метод добавляет новое ценовое предложение (новую цену) для товара</p>
	 *
	 *
	 *
	 *
	 * @param array $arFields  Ассоциативный массив параметров ценового предложения.
	 * Допустимые параметры: <ul> <li> <b>PRODUCT_ID </b> - код товара или торгового
	 * предложения (ID элемента инфоблока).;</li> <li> <b>EXTRA_ID</b> - код
	 * наценки;</li> <li> <b>CATALOG_GROUP_ID</b> - код типа цены;</li> <li> <b>PRICE</b> - цена;</li>
	 * <li> <b>CURRENCY</b> - валюта цены (обязательный параметр);</li> <li> <b>QUANTITY_FROM</b>
	 * - количество товара, начиная с приобретения которого действует
	 * эта цена;</li> <li> <b>QUANTITY_TO</b> - количество товара, при приобретении
	 * которого заканчивает действие эта цена. <p class="note">Если необходимо,
	 * чтобы значения параметров <b>QUANTITY_FROM</b> и <b>QUANTITY_TO</b> не были заданы,
	 * необходимо указать у них в качестве значения false либо не задавать
	 * поля <b>QUANTITY_FROM</b> и <b>QUANTITY_TO</b> в Update вообще. </p> </li> </ul> Если
	 * установлен код наценки, то появляется возможность автоматически
	 * пересчитывать эту цену при изменении базовой цены или процента
	 * наценки.
	 *
	 *
	 *
	 * @param boolean $boolRecalc = false Пересчитать цены. Если передать true, то включается механизм
	 * пересчета цен. <br> Если добавляется базовая цена (в <b>CATALOG_GROUP_ID</b>
	 * задан тип цен, являющийся базовым), будут пересчитаны все
	 * остальные типы цен для товара, если у них задан код наценки. <br>
	 * Если добавляется иная цена (не базовая), для нее задан код наценки
	 * и уже существует базовая - значения <b>PRICE</b> и <b>CURRENCY</b> буду
	 * пересчитаны. <br> Необязательный параметр. По умолчанию - <i>false</i>.
	 *
	 *
	 *
	 * @return mixed <p>Возвращает идентификатор добавленной цены в случае успешного
	 * сохранения и <i>false</i> - в противном случае. Для получения детальной
	 * информации об ошибке следует вызвать
	 * <b>$APPLICATION-&gt;GetException()</b>.</p><h4>События</h4><p>Метод работает с событиями
	 * <a href="http://dev.1c-bitrix.ruapi_help/catalog/events/onbeforepriceadd.php">OnBeforePriceAdd</a> и
	 * OnPriceAdd.</p><h4>Примечания</h4><p>Если параметр <b>$boolRecalc = true</b>, все равно
	 * необходимо указывать цену и валюту (в том случае, когда тип цены -
	 * не базовый). Если существует базовая цена, значения цены и валюты
	 * будут изменены, если нет - код наценки будет изменен на ноль.</p><p>В
	 * обработчиках события <b>OnBeforePriceAdd</b> можно запретить или, наоборот,
	 * включить пересчет цены. За это отвечает ключ <b>RECALC</b> массива
	 * данных, передаваемых в обработчик.</p>
	 *
	 *
	 * <h4>Example</h4> 
	 * <pre>
	 * <b>Добавление цены</b>&lt;?
	 * // Установим для товара с кодом 15 цену типа 2 в значение 29.95 USD
	 * $PRODUCT_ID = 15;
	 * $PRICE_TYPE_ID = 2;
	 * 
	 * $arFields = Array(
	 *     "PRODUCT_ID" =&gt; $PRODUCT_ID,
	 *     "CATALOG_GROUP_ID" =&gt; $PRICE_TYPE_ID,
	 *     "PRICE" =&gt; 29.95,
	 *     "CURRENCY" =&gt; "USD",
	 *     "QUANTITY_FROM" =&gt; 1,
	 *     "QUANTITY_TO" =&gt; 10
	 * );
	 * 
	 * $res = CPrice::GetList(
	 *         array(),
	 *         array(
	 *                 "PRODUCT_ID" =&gt; $PRODUCT_ID,
	 *                 "CATALOG_GROUP_ID" =&gt; $PRICE_TYPE_ID
	 *             )
	 *     );
	 * 
	 * if ($arr = $res-&gt;Fetch())
	 * {
	 *     CPrice::Update($arr["ID"], $arFields);
	 * }
	 * else
	 * {
	 *     CPrice::Add($arFields);
	 * }
	 * ?&gt;<b>Добавление цены с пересчетом (базовая существует)</b>$PRODUCT_ID = 15;
	 * $PRICE_TYPE_ID = 2;
	 * $arFields = array(
	 * 	"PRODUCT_ID" =&gt; $PRODUCT_ID,
	 * 	"CATALOG_GROUP_ID" =&gt; $PRICE_TYPE_ID,
	 *     "PRICE" =&gt; 0,
	 *     "CURRENCY" =&gt; "RUB",
	 *     "EXTRA_ID" =&gt; 4,
	 *     "QUANTITY_FROM" =&gt; 1,
	 *     "QUANTITY_TO" =&gt; 10
	 * );
	 * 
	 * 
	 * $obPrice = new CPrice();
	 * $obPrice-&gt;Add($arFields,true);
	 * Величина и валюта цены будет расчитана исходя из наценки и базовой цены.
	 * </pre>
	 *
	 *
	 *
	 * <h4>See Also</h4> 
	 * <ul> <li><a href="http://dev.1c-bitrix.ruapi_help/catalog/fields.php">Структура таблицы</a></li>
	 * <li>CPrice::CheckFields</li> <li>CPrice::Update</li> <li><a
	 * href="http://dev.1c-bitrix.ruapi_help/catalog/events/onbeforepriceadd.php">Событие OnBeforePriceAdd</a></li>
	 * <li>Событие OnPriceAdd</li> </ul><a name="examples"></a>
	 *
	 *
	 * @static
	 * @link http://dev.1c-bitrix.ru/api_help/catalog/classes/cprice/add.php
	 * @author Bitrix
	 */
	public static function Add($arFields,$boolRecalc = false)
	{
		global $DB;

		if (!CPrice::CheckFields("ADD", $arFields, 0))
			return false;

		$boolBase = false;
		$arFields['RECALC'] = ($boolRecalc === true ? true : false);

		$events = GetModuleEvents("catalog", "OnBeforePriceAdd");
		while ($arEvent = $events->Fetch())
		{
			ExecuteModuleEventEx($arEvent, array(&$arFields));
		}

		if (!empty($arFields['RECALC']) && $arFields['RECALC'] === true)
		{
			CPrice::ReCountFromBase($arFields,$boolBase);
		}

		$arInsert = $DB->PrepareInsert("b_catalog_price", $arFields);

		$strSql =
			"INSERT INTO b_catalog_price(".$arInsert[0].") ".
			"VALUES(".$arInsert[1].")";
		$DB->Query($strSql, false, "File: ".__FILE__."<br>Line: ".__LINE__);

		$ID = IntVal($DB->LastID());

		if ($ID > 0 && $boolBase == true)
		{
			CPrice::ReCountForBase($arFields);
		}

		$events = GetModuleEvents("catalog", "OnPriceAdd");
		while ($arEvent = $events->Fetch())
			ExecuteModuleEventEx($arEvent, array($ID, $arFields));

		// strange copy-paste bug
		$events = GetModuleEvents("sale", "OnPriceAdd");
		while ($arEvent = $events->Fetch())
			ExecuteModuleEventEx($arEvent, array($ID, $arFields));

		return $ID;
	}

	
	/**
	 * <p>Функция возвращает ценовое предложение по его коду ID </p>
	 *
	 *
	 *
	 *
	 * @param int $ID  Код ценового предложения.
	 *
	 *
	 *
	 * @return array <p>Возвращается ассоциативный массив с ключами</p><table class="tnormal"
	 * width="100%"> <tr> <th width="15%">Ключ</th> <th>Описание</th> </tr> <tr> <td>ID</td> <td>Код
	 * ценового предложения.</td> </tr> <tr> <td>PRODUCT_ID</td> <td>Код товара или
	 * торгового предложения (ID элемента инфоблока)</td> </tr> <tr> <td>EXTRA_ID</td>
	 * <td>Код наценки.</td> </tr> <tr> <td>CATALOG_GROUP_ID</td> <td>Код типа цены. </td> </tr> <tr>
	 * <td>PRICE</td> <td>Цена.</td> </tr> <tr> <td>CURRENCY</td> <td>Валюта.</td> </tr> <tr> <td>CAN_ACCESS</td>
	 * <td>Флаг (Y/N), может ли текущий пользователь видеть эту цену. </td> </tr>
	 * <tr> <td>CAN_BUY</td> <td>Флаг (Y/N), может ли текущий пользователь покупать по
	 * этой цене.</td> </tr> <tr> <td>CATALOG_GROUP_NAME</td> <td>Название группы цен на
	 * текущем языке. </td> </tr> <tr> <td>TIMESTAMP_X</td> <td> Дата последнего изменения
	 * записи. </td> </tr> <tr> <td>QUANTITY_FROM </td> <td>Количество товара, начиная с
	 * приобретения которого действует эта цена. </td> </tr> <tr> <td>QUANTITY_TO </td>
	 * <td>Количество товара, при приобретении которого заканчивает
	 * действие эта цена. </td> </tr> </table><a name="examples"></a>
	 *
	 *
	 * <h4>Example</h4> 
	 * <pre>
	 * &lt;?
	 * $ID = 11;
	 * $arPrice = CPrice::GetByID($ID);
	 * echo "Цена типа ".$arPrice["CATALOG_GROUP_NAME"].
	 *      " на товар с кодом ".$ID.": ";
	 * echo CurrencyFormat($arPrice["PRICE"], 
	 *                     $arPrice["CURRENCY"])."&lt;br&gt;";
	 * echo "Вы ".(($arPrice["CAN_ACCESS"]=="Y") ? 
	 *             "можете" : 
	 *             "не можете")." видеть эту цену";
	 * ?&gt;
	 * </pre>
	 *
	 *
	 * @static
	 * @link http://dev.1c-bitrix.ru/api_help/catalog/classes/cprice/cprice__getbyid.872661b0.php
	 * @author Bitrix
	 */
	public static function GetByID($ID)
	{
		global $DB, $USER;
		if (!$USER->IsAdmin())
		{
			$strSql =
				"SELECT CP.ID, CP.PRODUCT_ID, CP.EXTRA_ID, CP.CATALOG_GROUP_ID, CP.PRICE, ".
				"	CP.CURRENCY, CP.QUANTITY_FROM, CP.QUANTITY_TO, IF(CGG.ID IS NULL, 'N', 'Y') as CAN_ACCESS, CP.TMP_ID, ".
				"	CGL.NAME as CATALOG_GROUP_NAME, IF(CGG1.ID IS NULL, 'N', 'Y') as CAN_BUY, ".
				"	".$DB->DateToCharFunction("CP.TIMESTAMP_X", "FULL")." as TIMESTAMP_X ".
				"FROM b_catalog_price CP, b_catalog_group CG ".
				"	LEFT JOIN b_catalog_group2group CGG ON (CG.ID = CGG.CATALOG_GROUP_ID AND CGG.GROUP_ID IN (".$USER->GetGroups().") AND CGG.BUY <> 'Y') ".
				"	LEFT JOIN b_catalog_group2group CGG1 ON (CG.ID = CGG1.CATALOG_GROUP_ID AND CGG1.GROUP_ID IN (".$USER->GetGroups().") AND CGG1.BUY = 'Y') ".
				"	LEFT JOIN b_catalog_group_lang CGL ON (CG.ID = CGL.CATALOG_GROUP_ID AND CGL.LID = '".LANGUAGE_ID."') ".
				"WHERE CP.ID = ".IntVal($ID)." ".
				"	AND CP.CATALOG_GROUP_ID = CG.ID ".
				"GROUP BY CP.ID, CP.PRODUCT_ID, CP.EXTRA_ID, CP.CATALOG_GROUP_ID, CP.PRICE, CP.CURRENCY, CP.QUANTITY_FROM, CP.QUANTITY_TO, CP.TIMESTAMP_X ";
		}
		else
		{
			$strSql =
				"SELECT CP.ID, CP.PRODUCT_ID, CP.EXTRA_ID, CP.CATALOG_GROUP_ID, CP.PRICE, ".
				"	CP.CURRENCY, CP.QUANTITY_FROM, CP.QUANTITY_TO, 'Y' as CAN_ACCESS, CP.TMP_ID, CGL.NAME as CATALOG_GROUP_NAME, ".
				"	'Y' as CAN_BUY, ".
				"	".$DB->DateToCharFunction("CP.TIMESTAMP_X", "FULL")." as TIMESTAMP_X ".
				"FROM b_catalog_price CP ".
				"	LEFT JOIN b_catalog_group_lang CGL ON (CP.CATALOG_GROUP_ID = CGL.CATALOG_GROUP_ID AND CGL.LID = '".LANGUAGE_ID."') ".
				"WHERE CP.ID = ".IntVal($ID)." ";
		}
		$db_res = $DB->Query($strSql, false, "File: ".__FILE__."<br>Line: ".__LINE__);
		if ($res = $db_res->Fetch())
			return $res;

		return false;
	}

	
	/**
	 * <p>Функция возвращает результат выборки записей цен в соответствии со своими параметрами.</p>
	 *
	 *
	 *
	 *
	 * @param array $arOrder = array() Массив, в соответствии с которым сортируются результирующие
	 * записи. Массив имеет вид: <pre class="syntax">array( "название_поля1" =&gt;
	 * "направление_сортировки1", "название_поля2" =&gt;
	 * "направление_сортировки2", . . . )</pre> В качестве "название_поля<i>N</i>"
	 * может стоять любое поле цены, а в качестве
	 * "направление_сортировки<i>X</i>" могут быть значения "<i>ASC</i>" (по
	 * возрастанию) и "<i>DESC</i>" (по убыванию).<br><br> Если массив сортировки
	 * имеет несколько элементов, то результирующий набор сортируется
	 * последовательно по каждому элементу (т.е. сначала сортируется по
	 * первому элементу, потом результат сортируется по второму и
	 * т.д.). <br><br> Значение по умолчанию - пустой массив array() - означает,
	 * что результат отсортирован не будет.
	 *
	 *
	 *
	 * @param array $arFilter = array() Массив, в соответствии с которым фильтруются записи типов цены.
	 * Массив имеет вид: <pre class="syntax">array(
	 * "[модификатор1][оператор1]название_поля1" =&gt; "значение1",
	 * "[модификатор2][оператор2]название_поля2" =&gt; "значение2", . . . )</pre>
	 * Удовлетворяющие фильтру записи возвращаются в результате, а
	 * записи, которые не удовлетворяют условиям фильтра,
	 * отбрасываются.<br><br> Допустимыми являются следующие модификаторы:
	 * <ul> <li> <b> !</b> - отрицание;</li> <li> <b> +</b> - значения null, 0 и пустая строка
	 * так же удовлетворяют условиям фильтра.</li> </ul> Допустимыми
	 * являются следующие операторы: <ul> <li> <b>&gt;=</b> - значение поля больше
	 * или равно передаваемой в фильтр величины;</li> <li> <b>&gt;</b> - значение
	 * поля строго больше передаваемой в фильтр величины;</li> <li> <b>&lt;=</b> -
	 * значение поля меньше или равно передаваемой в фильтр величины;</li>
	 * <li> <b>&lt;</b> - значение поля строго меньше передаваемой в фильтр
	 * величины;</li> <li> <b>@</b> - значение поля находится в передаваемом в
	 * фильтр разделенном запятой списке значений;</li> <li> <b>~</b> - значение
	 * поля проверяется на соответствие передаваемому в фильтр
	 * шаблону;</li> <li> <b>%</b> - значение поля проверяется на соответствие
	 * передаваемой в фильтр строке в соответствии с языком запросов.</li>
	 * </ul> В качестве "название_поляX" может стоять любое поле типов
	 * цены.<br><br> Пример фильтра: <pre class="syntax">array("PRODUCT_ID" =&gt; 150)</pre> Этот
	 * фильтр означает "выбрать все записи, в которых значение в поле
	 * PRODUCT_ID (код товара) равно 150".<br><br> Значение по умолчанию - пустой
	 * массив array() - означает, что результат отфильтрован не будет.
	 *
	 *
	 *
	 * @param array $arGroupBy = false Массив полей, по которым группируются записи типов цены. Массив
	 * имеет вид: <pre class="syntax">array("название_поля1", "группирующая_функция2"
	 * =&gt; "название_поля2", . . .)</pre> В качестве "название_поля<i>N</i>" может
	 * стоять любое поле типов цены. В качестве группирующей функции
	 * могут стоять: <ul> <li> <b> COUNT</b> - подсчет количества;</li> <li> <b>AVG</b> -
	 * вычисление среднего значения;</li> <li> <b>MIN</b> - вычисление
	 * минимального значения;</li> <li> <b> MAX</b> - вычисление максимального
	 * значения;</li> <li> <b>SUM</b> - вычисление суммы.</li> </ul> Если массив пустой,
	 * то функция вернет число записей, удовлетворяющих фильтру.<br><br>
	 * Значение по умолчанию - <i>false</i> - означает, что результат
	 * группироваться не будет.
	 *
	 *
	 *
	 * @param array $arNavStartParams = false Массив параметров выборки. Может содержать следующие ключи: <ul>
	 * <li>"<b>nTopCount</b>" - количество возвращаемых функцией записей будет
	 * ограничено сверху значением этого ключа;</li> <li> любой ключ,
	 * принимаемый методом <b> CDBResult::NavQuery</b> в качестве третьего
	 * параметра.</li> </ul> Значение по умолчанию - <i>false</i> - означает, что
	 * параметров выборки нет.
	 *
	 *
	 *
	 * @param array $arSelectFields = array() Массив полей записей, которые будут возвращены функцией. Можно
	 * указать только те поля, которые необходимы. Если в массиве
	 * присутствует значение "*", то будут возвращены все доступные
	 * поля.<br><br> Значение по умолчанию - пустой массив array() - означает,
	 * что будут возвращены все поля основной таблицы запроса.
	 *
	 *
	 *
	 * @return CDBResult <p>Возвращается объект класса CDBResult, содержащий набор
	 * ассоциативных массивов с ключами:</p><table class="tnormal" width="100%"> <tr> <th
	 * width="15%">Ключ</th> <th>Описание</th> </tr> <tr> <td>ID</td> <td>Код ценового
	 * предложения.</td> </tr> <tr> <td>PRODUCT_ID</td> <td>Код товара или торгового
	 * предложения (ID элемента инфоблока).</td> </tr> <tr> <td>EXTRA_ID</td> <td>Код
	 * наценки.</td> </tr> <tr> <td>CATALOG_GROUP_ID</td> <td>Код типа цены.</td> </tr> <tr> <td>PRICE</td>
	 * <td>Цена.</td> </tr> <tr> <td>CURRENCY</td> <td>Валюта.</td> </tr> <tr> <td>CAN_ACCESS</td> <td>Флаг
	 * (Y/N), может ли текущий пользователь видеть эту цену.</td> </tr> <tr>
	 * <td>CAN_BUY</td> <td>Флаг (Y/N), может ли текущий пользователь покупать по
	 * этой цене.</td> </tr> <tr> <td>CATALOG_GROUP_NAME</td> <td>Название группы цен на
	 * текущем языке.</td> </tr> <tr> <td>TIMESTAMP_X</td> <td> Дата последнего изменения
	 * записи. </td> </tr> <tr> <td>QUANTITY_FROM </td> <td>Количество товара, начиная с
	 * приобретения которого действует эта цена. </td> </tr> <tr> <td>QUANTITY_TO </td>
	 * <td>Количество товара, при приобретении которого заканчивает
	 * действие эта цена.</td> </tr> </table><p> Если в качестве параметра arGroupBy
	 * передается пустой массив, то функция вернет число записей,
	 * удовлетворяющих фильтру. </p><a name="examples"></a>
	 *
	 *
	 * <h4>Example</h4> 
	 * <pre>
	 * &lt;?
	 * // Выведем цену типа $PRICE_TYPE_ID товара с кодом $PRODUCT_ID
	 * 
	 * $db_res = CPrice::GetList(
	 *         array(),
	 *         array(
	 *                 "PRODUCT_ID" =&gt; $PRODUCT_ID,
	 *                 "CATALOG_GROUP_ID" =&gt; $PRICE_TYPE_ID
	 *             )
	 *     );
	 * if ($ar_res = $db_res-&gt;Fetch())
	 * {
	 *     echo CurrencyFormat($ar_res["PRICE"], $ar_res["CURRENCY"]);
	 * }
	 * else
	 * {
	 *     echo "Цена не найдена!";
	 * }
	 * ?&gt;
	 * </pre>
	 *
	 *
	 * @static
	 * @link http://dev.1c-bitrix.ru/api_help/catalog/classes/cprice/cprice__getlist.8f7c2a3e.php
	 * @author Bitrix
	 */
	public static function GetList($arOrder = array(), $arFilter = array(), $arGroupBy = false, $arNavStartParams = false, $arSelectFields = array())
	{
		global $DB, $USER;

		// for old execution style
		if (!is_array($arOrder) && !is_array($arFilter))
		{
			$arOrder = strval($arOrder);
			$arFilter = strval($arFilter);
			if (strlen($arOrder) > 0 && strlen($arFilter) > 0)
				$arOrder = array($arOrder => $arFilter);
			else
				$arOrder = array();
			if (is_array($arGroupBy))
				$arFilter = $arGroupBy;
			else
				$arFilter = array();
			$arGroupBy = false;
		}

		if (count($arSelectFields) <= 0)
			$arSelectFields = array("ID", "PRODUCT_ID", "EXTRA_ID", "CATALOG_GROUP_ID", "PRICE", "CURRENCY", "TIMESTAMP_X", "QUANTITY_FROM", "QUANTITY_TO", "BASE", "SORT", "CATALOG_GROUP_NAME", "CAN_ACCESS", "CAN_BUY");

		// FIELDS -->
		$arFields = array(
				"ID" => array("FIELD" => "P.ID", "TYPE" => "int"),
				"PRODUCT_ID" => array("FIELD" => "P.PRODUCT_ID", "TYPE" => "int"),
				"EXTRA_ID" => array("FIELD" => "P.EXTRA_ID", "TYPE" => "int"),
				"CATALOG_GROUP_ID" => array("FIELD" => "P.CATALOG_GROUP_ID", "TYPE" => "int"),
				"PRICE" => array("FIELD" => "P.PRICE", "TYPE" => "double"),
				"CURRENCY" => array("FIELD" => "P.CURRENCY", "TYPE" => "string"),
				"TIMESTAMP_X" => array("FIELD" => "P.TIMESTAMP_X", "TYPE" => "datetime"),
				"QUANTITY_FROM" => array("FIELD" => "P.QUANTITY_FROM", "TYPE" => "int"),
				"QUANTITY_TO" => array("FIELD" => "P.QUANTITY_TO", "TYPE" => "int"),
				"TMP_ID" => array("FIELD" => "P.TMP_ID", "TYPE" => "string"),

				"BASE" => array("FIELD" => "CG.BASE", "TYPE" => "char", "FROM" => "INNER JOIN b_catalog_group CG ON (P.CATALOG_GROUP_ID = CG.ID)"),
				"SORT" => array("FIELD" => "CG.SORT", "TYPE" => "int", "FROM" => "INNER JOIN b_catalog_group CG ON (P.CATALOG_GROUP_ID = CG.ID)"),

				"PRODUCT_QUANTITY" => array("FIELD" => "CP.QUANTITY", "TYPE" => "int", "FROM" => "INNER JOIN b_catalog_product CP ON (P.PRODUCT_ID = CP.ID)"),
				"PRODUCT_QUANTITY_TRACE" => array("FIELD" => "IF (CP.QUANTITY_TRACE = 'D', '".$DB->ForSql(COption::GetOptionString('catalog','default_quantity_trace','N'))."', CP.QUANTITY_TRACE)", "TYPE" => "char", "FROM" => "INNER JOIN b_catalog_product CP ON (P.PRODUCT_ID = CP.ID)"),
				"PRODUCT_CAN_BUY_ZERO" => array("FIELD" => "IF (CP.CAN_BUY_ZERO = 'D', '".$DB->ForSql(COption::GetOptionString('catalog','default_can_buy_zero','N'))."', CP.CAN_BUY_ZERO)", "TYPE" => "char", "FROM" => "INNER JOIN b_catalog_product CP ON (P.PRODUCT_ID = CP.ID)"),
				"PRODUCT_NEGATIVE_AMOUNT_TRACE" => array("FIELD" => "IF (CP.NEGATIVE_AMOUNT_TRACE = 'D', '".$DB->ForSql(COption::GetOptionString('catalog','allow_negative_amount','N'))."', CP.NEGATIVE_AMOUNT_TRACE)", "TYPE" => "char", "FROM" => "INNER JOIN b_catalog_product CP ON (P.PRODUCT_ID = CP.ID)"),
				"PRODUCT_WEIGHT" => array("FIELD" => "CP.WEIGHT", "TYPE" => "int", "FROM" => "INNER JOIN b_catalog_product CP ON (P.PRODUCT_ID = CP.ID)"),

				"ELEMENT_IBLOCK_ID" => array("FIELD" => "IE.IBLOCK_ID", "TYPE" => "int", "FROM" => "INNER JOIN b_iblock_element IE ON (P.PRODUCT_ID = IE.ID)"),

				"CATALOG_GROUP_NAME" => array("FIELD" => "CGL.NAME", "TYPE" => "string", "FROM" => "LEFT JOIN b_catalog_group_lang CGL ON (CG.ID = CGL.CATALOG_GROUP_ID AND CGL.LID = '".LANGUAGE_ID."')"),
			);
		if (!$USER->IsAdmin())
		{
			$arFields["CAN_ACCESS"] = array("FIELD" => "IF(CGG.ID IS NULL, 'N', 'Y')", "TYPE" => "char", "FROM" => "LEFT JOIN b_catalog_group2group CGG ON (CG.ID = CGG.CATALOG_GROUP_ID AND CGG.GROUP_ID IN (".$USER->GetGroups().") AND CGG.BUY <> 'Y')");
			$arFields["CAN_BUY"] = array("FIELD" => "IF(CGG1.ID IS NULL, 'N', 'Y')", "TYPE" => "char", "FROM" => "LEFT JOIN b_catalog_group2group CGG1 ON (CG.ID = CGG1.CATALOG_GROUP_ID AND CGG1.GROUP_ID IN (".$USER->GetGroups().") AND CGG1.BUY = 'Y')");
		}
		else
		{
			$arFields["CAN_ACCESS"] = array("FIELD" => "'Y'", "TYPE" => "char");
			$arFields["CAN_BUY"] = array("FIELD" => "'Y'", "TYPE" => "char");
		}
		// <-- FIELDS

		$arSqls = CCatalog::PrepareSql($arFields, $arOrder, $arFilter, $arGroupBy, $arSelectFields);

		if ((array_key_exists("CAN_ACCESS", $arFields) || array_key_exists("CAN_BUY", $arFields)) && !$USER->IsAdmin())
			$arSqls["SELECT"] = str_replace("%%_DISTINCT_%%", "DISTINCT", $arSqls["SELECT"]);
		else
			$arSqls["SELECT"] = str_replace("%%_DISTINCT_%%", "", $arSqls["SELECT"]);

		if (is_array($arGroupBy) && count($arGroupBy)==0)
		{
			$strSql =
				"SELECT ".$arSqls["SELECT"]." ".
				"FROM b_catalog_price P ".
				"	".$arSqls["FROM"]." ";
			if (strlen($arSqls["WHERE"]) > 0)
				$strSql .= "WHERE ".$arSqls["WHERE"]." ";
			if (strlen($arSqls["GROUPBY"]) > 0)
				$strSql .= "GROUP BY ".$arSqls["GROUPBY"]." ";

			$dbRes = $DB->Query($strSql, false, "File: ".__FILE__."<br>Line: ".__LINE__);
			if ($arRes = $dbRes->Fetch())
				return $arRes["CNT"];
			else
				return False;
		}

		$strSql =
			"SELECT ".$arSqls["SELECT"]." ".
			"FROM b_catalog_price P ".
			"	".$arSqls["FROM"]." ";
		if (strlen($arSqls["WHERE"]) > 0)
			$strSql .= "WHERE ".$arSqls["WHERE"]." ";
		if (strlen($arSqls["GROUPBY"]) > 0)
			$strSql .= "GROUP BY ".$arSqls["GROUPBY"]." ";
		if (strlen($arSqls["ORDERBY"]) > 0)
			$strSql .= "ORDER BY ".$arSqls["ORDERBY"]." ";

		if (is_array($arNavStartParams) && IntVal($arNavStartParams["nTopCount"])<=0)
		{
			$strSql_tmp =
				"SELECT COUNT('x') as CNT ".
				"FROM b_catalog_price P ".
				"	".$arSqls["FROM"]." ";
			if (strlen($arSqls["WHERE"]) > 0)
				$strSql_tmp .= "WHERE ".$arSqls["WHERE"]." ";
			if (strlen($arSqls["GROUPBY"]) > 0)
				$strSql_tmp .= "GROUP BY ".$arSqls["GROUPBY"]." ";

			$dbRes = $DB->Query($strSql_tmp, false, "File: ".__FILE__."<br>Line: ".__LINE__);
			$cnt = 0;
			if (strlen($arSqls["GROUPBY"]) <= 0)
			{
				if ($arRes = $dbRes->Fetch())
					$cnt = $arRes["CNT"];
			}
			else
			{
				$cnt = $dbRes->SelectedRowsCount();
			}

			$dbRes = new CDBResult();

			$dbRes->NavQuery($strSql, $cnt, $arNavStartParams);
		}
		else
		{
			if (is_array($arNavStartParams) && IntVal($arNavStartParams["nTopCount"])>0)
				$strSql .= "LIMIT ".intval($arNavStartParams["nTopCount"]);

			$dbRes = $DB->Query($strSql, false, "File: ".__FILE__."<br>Line: ".__LINE__);
		}

		return $dbRes;
	}

	
	/**
	 * <p>Функция возвращает результат выборки записей цен в соответствии со своими параметрами.</p>
	 *
	 *
	 *
	 *
	 * @param array $arOrder = array() Массив, в соответствии с которым сортируются результирующие
	 * записи. Массив имеет вид: <pre class="syntax">array( "название_поля1" =&gt;
	 * "направление_сортировки1", "название_поля2" =&gt;
	 * "направление_сортировки2", . . . )</pre> В качестве "название_поля<i>N</i>"
	 * может стоять любое поле цены, а в качестве
	 * "направление_сортировки<i>X</i>" могут быть значения "<i>ASC</i>" (по
	 * возрастанию) и "<i>DESC</i>" (по убыванию).<br><br> Если массив сортировки
	 * имеет несколько элементов, то результирующий набор сортируется
	 * последовательно по каждому элементу (т.е. сначала сортируется по
	 * первому элементу, потом результат сортируется по второму и
	 * т.д.). <br><br> Значение по умолчанию - пустой массив array() - означает,
	 * что результат отсортирован не будет.
	 *
	 *
	 *
	 * @param array $arFilter = array() Массив, в соответствии с которым фильтруются записи типов цены.
	 * Массив имеет вид: <pre class="syntax">array(
	 * "[модификатор1][оператор1]название_поля1" =&gt; "значение1",
	 * "[модификатор2][оператор2]название_поля2" =&gt; "значение2", . . . )</pre>
	 * Удовлетворяющие фильтру записи возвращаются в результате, а
	 * записи, которые не удовлетворяют условиям фильтра,
	 * отбрасываются.<br><br> Допустимыми являются следующие модификаторы:
	 * <ul> <li> <b> !</b> - отрицание;</li> <li> <b> +</b> - значения null, 0 и пустая строка
	 * так же удовлетворяют условиям фильтра.</li> </ul> Допустимыми
	 * являются следующие операторы: <ul> <li> <b>&gt;=</b> - значение поля больше
	 * или равно передаваемой в фильтр величины;</li> <li> <b>&gt;</b> - значение
	 * поля строго больше передаваемой в фильтр величины;</li> <li> <b>&lt;=</b> -
	 * значение поля меньше или равно передаваемой в фильтр величины;</li>
	 * <li> <b>&lt;</b> - значение поля строго меньше передаваемой в фильтр
	 * величины;</li> <li> <b>@</b> - значение поля находится в передаваемом в
	 * фильтр разделенном запятой списке значений;</li> <li> <b>~</b> - значение
	 * поля проверяется на соответствие передаваемому в фильтр
	 * шаблону;</li> <li> <b>%</b> - значение поля проверяется на соответствие
	 * передаваемой в фильтр строке в соответствии с языком запросов.</li>
	 * </ul> В качестве "название_поляX" может стоять любое поле типов
	 * цены.<br><br> Пример фильтра: <pre class="syntax">array("PRODUCT_ID" =&gt; 150)</pre> Этот
	 * фильтр означает "выбрать все записи, в которых значение в поле
	 * PRODUCT_ID (код товара) равно 150".<br><br> Значение по умолчанию - пустой
	 * массив array() - означает, что результат отфильтрован не будет.
	 *
	 *
	 *
	 * @param array $arGroupBy = false Массив полей, по которым группируются записи типов цены. Массив
	 * имеет вид: <pre class="syntax">array("название_поля1", "группирующая_функция2"
	 * =&gt; "название_поля2", . . .)</pre> В качестве "название_поля<i>N</i>" может
	 * стоять любое поле типов цены. В качестве группирующей функции
	 * могут стоять: <ul> <li> <b> COUNT</b> - подсчет количества;</li> <li> <b>AVG</b> -
	 * вычисление среднего значения;</li> <li> <b>MIN</b> - вычисление
	 * минимального значения;</li> <li> <b> MAX</b> - вычисление максимального
	 * значения;</li> <li> <b>SUM</b> - вычисление суммы.</li> </ul> Если массив пустой,
	 * то функция вернет число записей, удовлетворяющих фильтру.<br><br>
	 * Значение по умолчанию - <i>false</i> - означает, что результат
	 * группироваться не будет.
	 *
	 *
	 *
	 * @param array $arNavStartParams = false Массив параметров выборки. Может содержать следующие ключи: <ul>
	 * <li>"<b>nTopCount</b>" - количество возвращаемых функцией записей будет
	 * ограничено сверху значением этого ключа;</li> <li> любой ключ,
	 * принимаемый методом <b> CDBResult::NavQuery</b> в качестве третьего
	 * параметра.</li> </ul> Значение по умолчанию - <i>false</i> - означает, что
	 * параметров выборки нет.
	 *
	 *
	 *
	 * @param array $arSelectFields = array() Массив полей записей, которые будут возвращены функцией. Можно
	 * указать только те поля, которые необходимы. Если в массиве
	 * присутствует значение "*", то будут возвращены все доступные
	 * поля.<br><br> Значение по умолчанию - пустой массив array() - означает,
	 * что будут возвращены все поля основной таблицы запроса.
	 *
	 *
	 *
	 * @return CDBResult <p>Возвращается объект класса CDBResult, содержащий набор
	 * ассоциативных массивов с ключами:</p><table class="tnormal" width="100%"> <tr> <th
	 * width="15%">Ключ</th> <th>Описание</th> </tr> <tr> <td>ID</td> <td>Код ценового
	 * предложения.</td> </tr> <tr> <td>PRODUCT_ID</td> <td>код товара или торгового
	 * предложения (ID элемента инфоблока)</td> </tr> <tr> <td>EXTRA_ID</td> <td>Код
	 * наценки.</td> </tr> <tr> <td>CATALOG_GROUP_ID</td> <td>Код типа цены.</td> </tr> <tr> <td>PRICE</td>
	 * <td>Цена.</td> </tr> <tr> <td>CURRENCY</td> <td>Валюта.</td> </tr> <tr> <td>TIMESTAMP_X</td> <td> Дата
	 * последнего изменения записи. </td> </tr> <tr> <td>QUANTITY_FROM </td> <td>Количество
	 * товара, начиная с приобретения которого действует эта цена. </td>
	 * </tr> <tr> <td>QUANTITY_TO </td> <td>Количество товара, при приобретении
	 * которого заканчивает действие эта цена.</td> </tr> <tr> <td>CATALOG_GROUP_BASE</td>
	 * <td>Флаг "Базовая" типа цены.</td> </tr> <tr> <td>CATALOG_GROUP_NAME</td> <td>Название
	 * группы цен на текущем языке.</td> </tr> <tr> <td>CATALOG_GROUP_SORT</td> <td>Индекс
	 * сортировки типа цены.</td> </tr> <tr> <td>GROUP_BUY</td> <td>Флаг "Разрешена
	 * покупка по этой цене"</td> </tr> </table><p> Если в качестве параметра arGroupBy
	 * передается пустой массив, то функция вернет число записей,
	 * удовлетворяющих фильтру. </p><a name="examples"></a>
	 *
	 *
	 * <h4>Example</h4> 
	 * <pre>
	 * &lt;?
	 * $dbProductPrice = CPrice::GetListEx(
	 *         array(),
	 *         array("PRODUCT_ID" =&gt; $ID),
	 *         false,
	 *         false,
	 *         array("ID", "CATALOG_GROUP_ID", "PRICE", "CURRENCY", "QUANTITY_FROM", "QUANTITY_TO")
	 *     );
	 * ?&gt;
	 * </pre>
	 *
	 *
	 * @static
	 * @link http://dev.1c-bitrix.ru/api_help/catalog/classes/cprice/cprice__getlistex.8f7c2a3d.php
	 * @author Bitrix
	 */
	public static function GetListEx($arOrder = array(), $arFilter = array(), $arGroupBy = false, $arNavStartParams = false, $arSelectFields = array())
	{
		global $DB;

		if (count($arSelectFields) <= 0)
			$arSelectFields = array("ID", "PRODUCT_ID", "EXTRA_ID", "CATALOG_GROUP_ID", "PRICE", "CURRENCY", "TIMESTAMP_X", "QUANTITY_FROM", "QUANTITY_TO", "TMP_ID");

		// FIELDS -->
		$arFields = array(
			"ID" => array("FIELD" => "P.ID", "TYPE" => "int"),
			"PRODUCT_ID" => array("FIELD" => "P.PRODUCT_ID", "TYPE" => "int"),
			"EXTRA_ID" => array("FIELD" => "P.EXTRA_ID", "TYPE" => "int"),
			"CATALOG_GROUP_ID" => array("FIELD" => "P.CATALOG_GROUP_ID", "TYPE" => "int"),
			"PRICE" => array("FIELD" => "P.PRICE", "TYPE" => "double"),
			"CURRENCY" => array("FIELD" => "P.CURRENCY", "TYPE" => "string"),
			"TIMESTAMP_X" => array("FIELD" => "P.TIMESTAMP_X", "TYPE" => "datetime"),
			"QUANTITY_FROM" => array("FIELD" => "P.QUANTITY_FROM", "TYPE" => "int"),
			"QUANTITY_TO" => array("FIELD" => "P.QUANTITY_TO", "TYPE" => "int"),
			"TMP_ID" => array("FIELD" => "P.TMP_ID", "TYPE" => "string"),

			"PRODUCT_QUANTITY" => array("FIELD" => "CP.QUANTITY", "TYPE" => "int", "FROM" => "INNER JOIN b_catalog_product CP ON (P.PRODUCT_ID = CP.ID)"),
			"PRODUCT_QUANTITY_TRACE" => array("FIELD" => "IF (CP.QUANTITY_TRACE = 'D', '".$DB->ForSql(COption::GetOptionString('catalog','default_quantity_trace','N'))."', CP.QUANTITY_TRACE)", "TYPE" => "char", "FROM" => "INNER JOIN b_catalog_product CP ON (P.PRODUCT_ID = CP.ID)"),
			"PRODUCT_CAN_BUY_ZERO" => array("FIELD" => "IF (CP.CAN_BUY_ZERO = 'D', '".$DB->ForSql(COption::GetOptionString('catalog','default_can_buy_zero','N'))."', CP.CAN_BUY_ZERO)", "TYPE" => "char", "FROM" => "INNER JOIN b_catalog_product CP ON (P.PRODUCT_ID = CP.ID)"),
			"PRODUCT_NEGATIVE_AMOUNT_TRACE" => array("FIELD" => "IF (CP.NEGATIVE_AMOUNT_TRACE = 'D', '".$DB->ForSql(COption::GetOptionString('catalog','allow_negative_amount','N'))."', CP.NEGATIVE_AMOUNT_TRACE)", "TYPE" => "char", "FROM" => "INNER JOIN b_catalog_product CP ON (P.PRODUCT_ID = CP.ID)"),
			"PRODUCT_WEIGHT" => array("FIELD" => "CP.WEIGHT", "TYPE" => "int", "FROM" => "INNER JOIN b_catalog_product CP ON (P.PRODUCT_ID = CP.ID)"),

			"ELEMENT_IBLOCK_ID" => array("FIELD" => "IE.IBLOCK_ID", "TYPE" => "int", "FROM" => "INNER JOIN b_iblock_element IE ON (P.PRODUCT_ID = IE.ID)"),
			"ELEMENT_NAME" => array("FIELD" => "IE.NAME", "TYPE" => "string", "FROM" => "INNER JOIN b_iblock_element IE ON (P.PRODUCT_ID = IE.ID)"),

			"CATALOG_GROUP_BASE" => array("FIELD" => "CG.BASE", "TYPE" => "char", "FROM" => "INNER JOIN b_catalog_group CG ON (P.CATALOG_GROUP_ID = CG.ID)"),
			"CATALOG_GROUP_SORT" => array("FIELD" => "CG.SORT", "TYPE" => "int", "FROM" => "INNER JOIN b_catalog_group CG ON (P.CATALOG_GROUP_ID = CG.ID)"),

			"CATALOG_GROUP_NAME" => array("FIELD" => "CGL.NAME", "TYPE" => "string", "FROM" => "LEFT JOIN b_catalog_group_lang CGL ON (P.CATALOG_GROUP_ID = CGL.CATALOG_GROUP_ID AND CGL.LID = '".LANGUAGE_ID."')"),

			"GROUP_GROUP_ID" => array("FIELD" => "CGG.GROUP_ID", "TYPE" => "int", "FROM" => "INNER JOIN b_catalog_group2group CGG ON (P.CATALOG_GROUP_ID = CGG.CATALOG_GROUP_ID)"),
			"GROUP_BUY" => array("FIELD" => "CGG.BUY", "TYPE" => "char", "FROM" => "INNER JOIN b_catalog_group2group CGG ON (P.CATALOG_GROUP_ID = CGG.CATALOG_GROUP_ID)")
		);
		// <-- FIELDS

		$arSqls = CCatalog::PrepareSql($arFields, $arOrder, $arFilter, $arGroupBy, $arSelectFields);

		$arSqls["SELECT"] = str_replace("%%_DISTINCT_%%", "", $arSqls["SELECT"]);

		if (is_array($arGroupBy) && count($arGroupBy)==0)
		{
			$strSql =
				"SELECT ".$arSqls["SELECT"]." ".
				"FROM b_catalog_price P ".
				"	".$arSqls["FROM"]." ";
			if (strlen($arSqls["WHERE"]) > 0)
				$strSql .= "WHERE ".$arSqls["WHERE"]." ";
			if (strlen($arSqls["GROUPBY"]) > 0)
				$strSql .= "GROUP BY ".$arSqls["GROUPBY"]." ";

			$dbRes = $DB->Query($strSql, false, "File: ".__FILE__."<br>Line: ".__LINE__);
			if ($arRes = $dbRes->Fetch())
				return $arRes["CNT"];
			else
				return False;
		}

		$strSql =
			"SELECT ".$arSqls["SELECT"]." ".
			"FROM b_catalog_price P ".
			"	".$arSqls["FROM"]." ";
		if (strlen($arSqls["WHERE"]) > 0)
			$strSql .= "WHERE ".$arSqls["WHERE"]." ";
		if (strlen($arSqls["GROUPBY"]) > 0)
			$strSql .= "GROUP BY ".$arSqls["GROUPBY"]." ";
		if (strlen($arSqls["ORDERBY"]) > 0)
			$strSql .= "ORDER BY ".$arSqls["ORDERBY"]." ";

		if (is_array($arNavStartParams) && IntVal($arNavStartParams["nTopCount"])<=0)
		{
			$strSql_tmp =
				"SELECT COUNT('x') as CNT ".
				"FROM b_catalog_price P ".
				"	".$arSqls["FROM"]." ";
			if (strlen($arSqls["WHERE"]) > 0)
				$strSql_tmp .= "WHERE ".$arSqls["WHERE"]." ";
			if (strlen($arSqls["GROUPBY"]) > 0)
				$strSql_tmp .= "GROUP BY ".$arSqls["GROUPBY"]." ";

			$dbRes = $DB->Query($strSql_tmp, false, "File: ".__FILE__."<br>Line: ".__LINE__);
			$cnt = 0;
			if (strlen($arSqls["GROUPBY"]) <= 0)
			{
				if ($arRes = $dbRes->Fetch())
					$cnt = $arRes["CNT"];
			}
			else
			{
				$cnt = $dbRes->SelectedRowsCount();
			}

			$dbRes = new CDBResult();

			$dbRes->NavQuery($strSql, $cnt, $arNavStartParams);
		}
		else
		{
			if (is_array($arNavStartParams) && IntVal($arNavStartParams["nTopCount"])>0)
				$strSql .= "LIMIT ".intval($arNavStartParams["nTopCount"]);

			$dbRes = $DB->Query($strSql, false, "File: ".__FILE__."<br>Line: ".__LINE__);
		}

		return $dbRes;
	}
}
?>