<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'AbstractController' => $baseDir . '/application/controllers/Abstract.php',
    'AdminController' => $baseDir . '/application/controllers/Admin.php',
    'Cache_Cache' => $baseDir . '/application/library/Cache/Cache.php',
    'Cache_Driver_Redis' => $baseDir . '/application/library/Cache/Driver/Redis.php',
    'CholeskyDecomposition' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/JAMA/CholeskyDecomposition.php',
    'Cli' => $baseDir . '/application/library/Cli.php',
    'Config' => $baseDir . '/application/library/Config.php',
    'ConfigController' => $baseDir . '/application/controllers/Config.php',
    'CronController' => $baseDir . '/application/controllers/Cron.php',
    'DaemonController' => $baseDir . '/application/controllers/Daemon.php',
    'EigenvalueDecomposition' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/JAMA/EigenvalueDecomposition.php',
    'ErrorController' => $baseDir . '/application/controllers/Error.php',
    'FinanceController' => $baseDir . '/application/controllers/Finance.php',
    'Http\\CaseInsensitiveArray' => $baseDir . '/application/library/Http/CaseInsensitiveArray.php',
    'Http\\Curl' => $baseDir . '/application/library/Http/Curl.php',
    'Http\\MultiCurl' => $baseDir . '/application/library/Http/MultiCurl.php',
    'IndexController' => $baseDir . '/application/controllers/Index.php',
    'Ldap' => $baseDir . '/application/library/Ldap.php',
    'Log_Driver_File' => $baseDir . '/application/library/Log/Driver/File.php',
    'Log_Log' => $baseDir . '/application/library/Log/Log.php',
    'LoginController' => $baseDir . '/application/controllers/Login.php',
    'Mail_mail' => $baseDir . '/application/library/Mail/Mail_mail.php',
    'Memcache' => $baseDir . '/application/library/Cache/Driver/Memcache.php',
    'Models_Config' => $baseDir . '/application/library/Models/Config.php',
    'Models_Crontab' => $baseDir . '/application/library/Models/Crontab.php',
    'Models_Daemon' => $baseDir . '/application/library/Models/Daemon.php',
    'Models_Daemonrecord' => $baseDir . '/application/library/Models/Daemonrecord.php',
    'Models_Eloquent' => $baseDir . '/application/library/Models/Eloquent.php',
    'Models_Login' => $baseDir . '/application/library/Models/Login.php',
    'Models_Server' => $baseDir . '/application/library/Models/Server.php',
    'PHPExcel' => $baseDir . '/application/library/Phpexcel/PHPExcel.php',
    'PHPExcel_Autoloader' => $baseDir . '/application/library/Phpexcel/PHPExcel/Autoloader.php',
    'PHPExcel_Best_Fit' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/trend/bestFitClass.php',
    'PHPExcel_CachedObjectStorageFactory' => $baseDir . '/application/library/Phpexcel/PHPExcel/CachedObjectStorageFactory.php',
    'PHPExcel_CachedObjectStorage_APC' => $baseDir . '/application/library/Phpexcel/PHPExcel/CachedObjectStorage/APC.php',
    'PHPExcel_CachedObjectStorage_CacheBase' => $baseDir . '/application/library/Phpexcel/PHPExcel/CachedObjectStorage/CacheBase.php',
    'PHPExcel_CachedObjectStorage_DiscISAM' => $baseDir . '/application/library/Phpexcel/PHPExcel/CachedObjectStorage/DiscISAM.php',
    'PHPExcel_CachedObjectStorage_ICache' => $baseDir . '/application/library/Phpexcel/PHPExcel/CachedObjectStorage/ICache.php',
    'PHPExcel_CachedObjectStorage_Igbinary' => $baseDir . '/application/library/Phpexcel/PHPExcel/CachedObjectStorage/Igbinary.php',
    'PHPExcel_CachedObjectStorage_Memcache' => $baseDir . '/application/library/Phpexcel/PHPExcel/CachedObjectStorage/Memcache.php',
    'PHPExcel_CachedObjectStorage_Memory' => $baseDir . '/application/library/Phpexcel/PHPExcel/CachedObjectStorage/Memory.php',
    'PHPExcel_CachedObjectStorage_MemoryGZip' => $baseDir . '/application/library/Phpexcel/PHPExcel/CachedObjectStorage/MemoryGZip.php',
    'PHPExcel_CachedObjectStorage_MemorySerialized' => $baseDir . '/application/library/Phpexcel/PHPExcel/CachedObjectStorage/MemorySerialized.php',
    'PHPExcel_CachedObjectStorage_PHPTemp' => $baseDir . '/application/library/Phpexcel/PHPExcel/CachedObjectStorage/PHPTemp.php',
    'PHPExcel_CachedObjectStorage_SQLite' => $baseDir . '/application/library/Phpexcel/PHPExcel/CachedObjectStorage/SQLite.php',
    'PHPExcel_CachedObjectStorage_SQLite3' => $baseDir . '/application/library/Phpexcel/PHPExcel/CachedObjectStorage/SQLite3.php',
    'PHPExcel_CachedObjectStorage_Wincache' => $baseDir . '/application/library/Phpexcel/PHPExcel/CachedObjectStorage/Wincache.php',
    'PHPExcel_CalcEngine_CyclicReferenceStack' => $baseDir . '/application/library/Phpexcel/PHPExcel/CalcEngine/CyclicReferenceStack.php',
    'PHPExcel_CalcEngine_Logger' => $baseDir . '/application/library/Phpexcel/PHPExcel/CalcEngine/Logger.php',
    'PHPExcel_Calculation' => $baseDir . '/application/library/Phpexcel/PHPExcel/Calculation.php',
    'PHPExcel_Calculation_Database' => $baseDir . '/application/library/Phpexcel/PHPExcel/Calculation/Database.php',
    'PHPExcel_Calculation_DateTime' => $baseDir . '/application/library/Phpexcel/PHPExcel/Calculation/DateTime.php',
    'PHPExcel_Calculation_Engineering' => $baseDir . '/application/library/Phpexcel/PHPExcel/Calculation/Engineering.php',
    'PHPExcel_Calculation_Exception' => $baseDir . '/application/library/Phpexcel/PHPExcel/Calculation/Exception.php',
    'PHPExcel_Calculation_ExceptionHandler' => $baseDir . '/application/library/Phpexcel/PHPExcel/Calculation/ExceptionHandler.php',
    'PHPExcel_Calculation_Financial' => $baseDir . '/application/library/Phpexcel/PHPExcel/Calculation/Financial.php',
    'PHPExcel_Calculation_FormulaParser' => $baseDir . '/application/library/Phpexcel/PHPExcel/Calculation/FormulaParser.php',
    'PHPExcel_Calculation_FormulaToken' => $baseDir . '/application/library/Phpexcel/PHPExcel/Calculation/FormulaToken.php',
    'PHPExcel_Calculation_Function' => $baseDir . '/application/library/Phpexcel/PHPExcel/Calculation/Function.php',
    'PHPExcel_Calculation_Functions' => $baseDir . '/application/library/Phpexcel/PHPExcel/Calculation/Functions.php',
    'PHPExcel_Calculation_Logical' => $baseDir . '/application/library/Phpexcel/PHPExcel/Calculation/Logical.php',
    'PHPExcel_Calculation_LookupRef' => $baseDir . '/application/library/Phpexcel/PHPExcel/Calculation/LookupRef.php',
    'PHPExcel_Calculation_MathTrig' => $baseDir . '/application/library/Phpexcel/PHPExcel/Calculation/MathTrig.php',
    'PHPExcel_Calculation_Statistical' => $baseDir . '/application/library/Phpexcel/PHPExcel/Calculation/Statistical.php',
    'PHPExcel_Calculation_TextData' => $baseDir . '/application/library/Phpexcel/PHPExcel/Calculation/TextData.php',
    'PHPExcel_Calculation_Token_Stack' => $baseDir . '/application/library/Phpexcel/PHPExcel/Calculation/Token/Stack.php',
    'PHPExcel_Cell' => $baseDir . '/application/library/Phpexcel/PHPExcel/Cell.php',
    'PHPExcel_Cell_AdvancedValueBinder' => $baseDir . '/application/library/Phpexcel/PHPExcel/Cell/AdvancedValueBinder.php',
    'PHPExcel_Cell_DataType' => $baseDir . '/application/library/Phpexcel/PHPExcel/Cell/DataType.php',
    'PHPExcel_Cell_DataValidation' => $baseDir . '/application/library/Phpexcel/PHPExcel/Cell/DataValidation.php',
    'PHPExcel_Cell_DefaultValueBinder' => $baseDir . '/application/library/Phpexcel/PHPExcel/Cell/DefaultValueBinder.php',
    'PHPExcel_Cell_Hyperlink' => $baseDir . '/application/library/Phpexcel/PHPExcel/Cell/Hyperlink.php',
    'PHPExcel_Cell_IValueBinder' => $baseDir . '/application/library/Phpexcel/PHPExcel/Cell/IValueBinder.php',
    'PHPExcel_Chart' => $baseDir . '/application/library/Phpexcel/PHPExcel/Chart.php',
    'PHPExcel_Chart_DataSeries' => $baseDir . '/application/library/Phpexcel/PHPExcel/Chart/DataSeries.php',
    'PHPExcel_Chart_DataSeriesValues' => $baseDir . '/application/library/Phpexcel/PHPExcel/Chart/DataSeriesValues.php',
    'PHPExcel_Chart_Exception' => $baseDir . '/application/library/Phpexcel/PHPExcel/Chart/Exception.php',
    'PHPExcel_Chart_Layout' => $baseDir . '/application/library/Phpexcel/PHPExcel/Chart/Layout.php',
    'PHPExcel_Chart_Legend' => $baseDir . '/application/library/Phpexcel/PHPExcel/Chart/Legend.php',
    'PHPExcel_Chart_PlotArea' => $baseDir . '/application/library/Phpexcel/PHPExcel/Chart/PlotArea.php',
    'PHPExcel_Chart_Renderer_jpgraph' => $baseDir . '/application/library/Phpexcel/PHPExcel/Chart/Renderer/jpgraph.php',
    'PHPExcel_Chart_Title' => $baseDir . '/application/library/Phpexcel/PHPExcel/Chart/Title.php',
    'PHPExcel_Comment' => $baseDir . '/application/library/Phpexcel/PHPExcel/Comment.php',
    'PHPExcel_DocumentProperties' => $baseDir . '/application/library/Phpexcel/PHPExcel/DocumentProperties.php',
    'PHPExcel_DocumentSecurity' => $baseDir . '/application/library/Phpexcel/PHPExcel/DocumentSecurity.php',
    'PHPExcel_Exception' => $baseDir . '/application/library/Phpexcel/PHPExcel/Exception.php',
    'PHPExcel_Exponential_Best_Fit' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/trend/exponentialBestFitClass.php',
    'PHPExcel_HashTable' => $baseDir . '/application/library/Phpexcel/PHPExcel/HashTable.php',
    'PHPExcel_IComparable' => $baseDir . '/application/library/Phpexcel/PHPExcel/IComparable.php',
    'PHPExcel_IOFactory' => $baseDir . '/application/library/Phpexcel/PHPExcel/IOFactory.php',
    'PHPExcel_Linear_Best_Fit' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/trend/linearBestFitClass.php',
    'PHPExcel_Logarithmic_Best_Fit' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/trend/logarithmicBestFitClass.php',
    'PHPExcel_NamedRange' => $baseDir . '/application/library/Phpexcel/PHPExcel/NamedRange.php',
    'PHPExcel_Polynomial_Best_Fit' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/trend/polynomialBestFitClass.php',
    'PHPExcel_Power_Best_Fit' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/trend/powerBestFitClass.php',
    'PHPExcel_Reader_Abstract' => $baseDir . '/application/library/Phpexcel/PHPExcel/Reader/Abstract.php',
    'PHPExcel_Reader_CSV' => $baseDir . '/application/library/Phpexcel/PHPExcel/Reader/CSV.php',
    'PHPExcel_Reader_DefaultReadFilter' => $baseDir . '/application/library/Phpexcel/PHPExcel/Reader/DefaultReadFilter.php',
    'PHPExcel_Reader_Excel2003XML' => $baseDir . '/application/library/Phpexcel/PHPExcel/Reader/Excel2003XML.php',
    'PHPExcel_Reader_Excel2007' => $baseDir . '/application/library/Phpexcel/PHPExcel/Reader/Excel2007.php',
    'PHPExcel_Reader_Excel2007_Chart' => $baseDir . '/application/library/Phpexcel/PHPExcel/Reader/Excel2007/Chart.php',
    'PHPExcel_Reader_Excel2007_Theme' => $baseDir . '/application/library/Phpexcel/PHPExcel/Reader/Excel2007/Theme.php',
    'PHPExcel_Reader_Excel5' => $baseDir . '/application/library/Phpexcel/PHPExcel/Reader/Excel5.php',
    'PHPExcel_Reader_Excel5_Escher' => $baseDir . '/application/library/Phpexcel/PHPExcel/Reader/Excel5/Escher.php',
    'PHPExcel_Reader_Exception' => $baseDir . '/application/library/Phpexcel/PHPExcel/Reader/Exception.php',
    'PHPExcel_Reader_Gnumeric' => $baseDir . '/application/library/Phpexcel/PHPExcel/Reader/Gnumeric.php',
    'PHPExcel_Reader_HTML' => $baseDir . '/application/library/Phpexcel/PHPExcel/Reader/HTML.php',
    'PHPExcel_Reader_IReadFilter' => $baseDir . '/application/library/Phpexcel/PHPExcel/Reader/IReadFilter.php',
    'PHPExcel_Reader_IReader' => $baseDir . '/application/library/Phpexcel/PHPExcel/Reader/IReader.php',
    'PHPExcel_Reader_OOCalc' => $baseDir . '/application/library/Phpexcel/PHPExcel/Reader/OOCalc.php',
    'PHPExcel_Reader_SYLK' => $baseDir . '/application/library/Phpexcel/PHPExcel/Reader/SYLK.php',
    'PHPExcel_ReferenceHelper' => $baseDir . '/application/library/Phpexcel/PHPExcel/ReferenceHelper.php',
    'PHPExcel_RichText' => $baseDir . '/application/library/Phpexcel/PHPExcel/RichText.php',
    'PHPExcel_RichText_ITextElement' => $baseDir . '/application/library/Phpexcel/PHPExcel/RichText/ITextElement.php',
    'PHPExcel_RichText_Run' => $baseDir . '/application/library/Phpexcel/PHPExcel/RichText/Run.php',
    'PHPExcel_RichText_TextElement' => $baseDir . '/application/library/Phpexcel/PHPExcel/RichText/TextElement.php',
    'PHPExcel_Settings' => $baseDir . '/application/library/Phpexcel/PHPExcel/Settings.php',
    'PHPExcel_Shared_CodePage' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/CodePage.php',
    'PHPExcel_Shared_Date' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/Date.php',
    'PHPExcel_Shared_Drawing' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/Drawing.php',
    'PHPExcel_Shared_Escher' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/Escher.php',
    'PHPExcel_Shared_Escher_DgContainer' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/Escher/DgContainer.php',
    'PHPExcel_Shared_Escher_DgContainer_SpgrContainer' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/Escher/DgContainer/SpgrContainer.php',
    'PHPExcel_Shared_Escher_DgContainer_SpgrContainer_SpContainer' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/Escher/DgContainer/SpgrContainer/SpContainer.php',
    'PHPExcel_Shared_Escher_DggContainer' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/Escher/DggContainer.php',
    'PHPExcel_Shared_Escher_DggContainer_BstoreContainer' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/Escher/DggContainer/BstoreContainer.php',
    'PHPExcel_Shared_Escher_DggContainer_BstoreContainer_BSE' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/Escher/DggContainer/BstoreContainer/BSE.php',
    'PHPExcel_Shared_Escher_DggContainer_BstoreContainer_BSE_Blip' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/Escher/DggContainer/BstoreContainer/BSE/Blip.php',
    'PHPExcel_Shared_Excel5' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/Excel5.php',
    'PHPExcel_Shared_File' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/File.php',
    'PHPExcel_Shared_Font' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/Font.php',
    'PHPExcel_Shared_JAMA_LUDecomposition' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/JAMA/LUDecomposition.php',
    'PHPExcel_Shared_JAMA_Matrix' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/JAMA/Matrix.php',
    'PHPExcel_Shared_JAMA_QRDecomposition' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/JAMA/QRDecomposition.php',
    'PHPExcel_Shared_OLE' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/OLE.php',
    'PHPExcel_Shared_OLERead' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/OLERead.php',
    'PHPExcel_Shared_OLE_ChainedBlockStream' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/OLE/ChainedBlockStream.php',
    'PHPExcel_Shared_OLE_PPS' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/OLE/PPS.php',
    'PHPExcel_Shared_OLE_PPS_File' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/OLE/PPS/File.php',
    'PHPExcel_Shared_OLE_PPS_Root' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/OLE/PPS/Root.php',
    'PHPExcel_Shared_PasswordHasher' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/PasswordHasher.php',
    'PHPExcel_Shared_String' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/String.php',
    'PHPExcel_Shared_TimeZone' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/TimeZone.php',
    'PHPExcel_Shared_XMLWriter' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/XMLWriter.php',
    'PHPExcel_Shared_ZipArchive' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/ZipArchive.php',
    'PHPExcel_Shared_ZipStreamWrapper' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/ZipStreamWrapper.php',
    'PHPExcel_Style' => $baseDir . '/application/library/Phpexcel/PHPExcel/Style.php',
    'PHPExcel_Style_Alignment' => $baseDir . '/application/library/Phpexcel/PHPExcel/Style/Alignment.php',
    'PHPExcel_Style_Border' => $baseDir . '/application/library/Phpexcel/PHPExcel/Style/Border.php',
    'PHPExcel_Style_Borders' => $baseDir . '/application/library/Phpexcel/PHPExcel/Style/Borders.php',
    'PHPExcel_Style_Color' => $baseDir . '/application/library/Phpexcel/PHPExcel/Style/Color.php',
    'PHPExcel_Style_Conditional' => $baseDir . '/application/library/Phpexcel/PHPExcel/Style/Conditional.php',
    'PHPExcel_Style_Fill' => $baseDir . '/application/library/Phpexcel/PHPExcel/Style/Fill.php',
    'PHPExcel_Style_Font' => $baseDir . '/application/library/Phpexcel/PHPExcel/Style/Font.php',
    'PHPExcel_Style_NumberFormat' => $baseDir . '/application/library/Phpexcel/PHPExcel/Style/NumberFormat.php',
    'PHPExcel_Style_Protection' => $baseDir . '/application/library/Phpexcel/PHPExcel/Style/Protection.php',
    'PHPExcel_Style_Supervisor' => $baseDir . '/application/library/Phpexcel/PHPExcel/Style/Supervisor.php',
    'PHPExcel_Worksheet' => $baseDir . '/application/library/Phpexcel/PHPExcel/Worksheet.php',
    'PHPExcel_WorksheetIterator' => $baseDir . '/application/library/Phpexcel/PHPExcel/WorksheetIterator.php',
    'PHPExcel_Worksheet_AutoFilter' => $baseDir . '/application/library/Phpexcel/PHPExcel/Worksheet/AutoFilter.php',
    'PHPExcel_Worksheet_AutoFilter_Column' => $baseDir . '/application/library/Phpexcel/PHPExcel/Worksheet/AutoFilter/Column.php',
    'PHPExcel_Worksheet_AutoFilter_Column_Rule' => $baseDir . '/application/library/Phpexcel/PHPExcel/Worksheet/AutoFilter/Column/Rule.php',
    'PHPExcel_Worksheet_BaseDrawing' => $baseDir . '/application/library/Phpexcel/PHPExcel/Worksheet/BaseDrawing.php',
    'PHPExcel_Worksheet_CellIterator' => $baseDir . '/application/library/Phpexcel/PHPExcel/Worksheet/CellIterator.php',
    'PHPExcel_Worksheet_ColumnDimension' => $baseDir . '/application/library/Phpexcel/PHPExcel/Worksheet/ColumnDimension.php',
    'PHPExcel_Worksheet_Drawing' => $baseDir . '/application/library/Phpexcel/PHPExcel/Worksheet/Drawing.php',
    'PHPExcel_Worksheet_Drawing_Shadow' => $baseDir . '/application/library/Phpexcel/PHPExcel/Worksheet/Drawing/Shadow.php',
    'PHPExcel_Worksheet_HeaderFooter' => $baseDir . '/application/library/Phpexcel/PHPExcel/Worksheet/HeaderFooter.php',
    'PHPExcel_Worksheet_HeaderFooterDrawing' => $baseDir . '/application/library/Phpexcel/PHPExcel/Worksheet/HeaderFooterDrawing.php',
    'PHPExcel_Worksheet_MemoryDrawing' => $baseDir . '/application/library/Phpexcel/PHPExcel/Worksheet/MemoryDrawing.php',
    'PHPExcel_Worksheet_PageMargins' => $baseDir . '/application/library/Phpexcel/PHPExcel/Worksheet/PageMargins.php',
    'PHPExcel_Worksheet_PageSetup' => $baseDir . '/application/library/Phpexcel/PHPExcel/Worksheet/PageSetup.php',
    'PHPExcel_Worksheet_Protection' => $baseDir . '/application/library/Phpexcel/PHPExcel/Worksheet/Protection.php',
    'PHPExcel_Worksheet_Row' => $baseDir . '/application/library/Phpexcel/PHPExcel/Worksheet/Row.php',
    'PHPExcel_Worksheet_RowDimension' => $baseDir . '/application/library/Phpexcel/PHPExcel/Worksheet/RowDimension.php',
    'PHPExcel_Worksheet_RowIterator' => $baseDir . '/application/library/Phpexcel/PHPExcel/Worksheet/RowIterator.php',
    'PHPExcel_Worksheet_SheetView' => $baseDir . '/application/library/Phpexcel/PHPExcel/Worksheet/SheetView.php',
    'PHPExcel_Writer_Abstract' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Abstract.php',
    'PHPExcel_Writer_CSV' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/CSV.php',
    'PHPExcel_Writer_Excel2007' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Excel2007.php',
    'PHPExcel_Writer_Excel2007_Chart' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Excel2007/Chart.php',
    'PHPExcel_Writer_Excel2007_Comments' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Excel2007/Comments.php',
    'PHPExcel_Writer_Excel2007_ContentTypes' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Excel2007/ContentTypes.php',
    'PHPExcel_Writer_Excel2007_DocProps' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Excel2007/DocProps.php',
    'PHPExcel_Writer_Excel2007_Drawing' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Excel2007/Drawing.php',
    'PHPExcel_Writer_Excel2007_Rels' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Excel2007/Rels.php',
    'PHPExcel_Writer_Excel2007_StringTable' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Excel2007/StringTable.php',
    'PHPExcel_Writer_Excel2007_Style' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Excel2007/Style.php',
    'PHPExcel_Writer_Excel2007_Theme' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Excel2007/Theme.php',
    'PHPExcel_Writer_Excel2007_Workbook' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Excel2007/Workbook.php',
    'PHPExcel_Writer_Excel2007_Worksheet' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Excel2007/Worksheet.php',
    'PHPExcel_Writer_Excel2007_WriterPart' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Excel2007/WriterPart.php',
    'PHPExcel_Writer_Excel5' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Excel5.php',
    'PHPExcel_Writer_Excel5_BIFFwriter' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Excel5/BIFFwriter.php',
    'PHPExcel_Writer_Excel5_Escher' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Excel5/Escher.php',
    'PHPExcel_Writer_Excel5_Font' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Excel5/Font.php',
    'PHPExcel_Writer_Excel5_Parser' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Excel5/Parser.php',
    'PHPExcel_Writer_Excel5_Workbook' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Excel5/Workbook.php',
    'PHPExcel_Writer_Excel5_Worksheet' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Excel5/Worksheet.php',
    'PHPExcel_Writer_Excel5_Xf' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Excel5/Xf.php',
    'PHPExcel_Writer_Exception' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/Exception.php',
    'PHPExcel_Writer_HTML' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/HTML.php',
    'PHPExcel_Writer_IWriter' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/IWriter.php',
    'PHPExcel_Writer_PDF' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/PDF.php',
    'PHPExcel_Writer_PDF_Core' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/PDF/Core.php',
    'PHPExcel_Writer_PDF_DomPDF' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/PDF/DomPDF.php',
    'PHPExcel_Writer_PDF_mPDF' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/PDF/mPDF.php',
    'PHPExcel_Writer_PDF_tcPDF' => $baseDir . '/application/library/Phpexcel/PHPExcel/Writer/PDF/tcPDF.php',
    'PHPMailer' => $baseDir . '/application/library/Mail/class.phpmailer.php',
    'POP3' => $baseDir . '/application/library/Mail/class.pop3.php',
    'PclZip' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/PCLZip/pclzip.lib.php',
    'Proc' => $baseDir . '/application/library/Proc.php',
    'Process' => $baseDir . '/application/library/Process.php',
    'PublicController' => $baseDir . '/application/controllers/Public.php',
    'Redis' => $baseDir . '/application/library/Cache/Redis.php',
    'RedisArray' => $baseDir . '/application/library/Cache/Redis.php',
    'RedisException' => $baseDir . '/application/library/Cache/Redis.php',
    'SMS_Send' => $baseDir . '/application/library/SMS/Send.php',
    'SMTP' => $baseDir . '/application/library/Mail/class.smtp.php',
    'ServerController' => $baseDir . '/application/controllers/Server.php',
    'SingularValueDecomposition' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/JAMA/SingularValueDecomposition.php',
    'Tool' => $baseDir . '/application/library/Tool.php',
    'UploadController' => $baseDir . '/application/controllers/Upload.php',
    'Upload_Image' => $baseDir . '/application/library/Upload/Image.php',
    'Upload_Upload' => $baseDir . '/application/library/Upload/Upload.php',
    'UserController' => $baseDir . '/application/controllers/User.php',
    'UserEloquentModel' => $baseDir . '/application/library/Models/User.php',
    'Util_Common' => $baseDir . '/application/library/Util/Common.php',
    'Util_CryptAES' => $baseDir . '/application/library/Util/CryptAES.php',
    'Util_Page' => $baseDir . '/application/library/Util/Page.php',
    'Util_Session' => $baseDir . '/application/library/Util/Session.php',
    'Validation' => $baseDir . '/application/library/Validation.php',
    'phpmailerException' => $baseDir . '/application/library/Mail/class.phpmailer.php',
    'trendClass' => $baseDir . '/application/library/Phpexcel/PHPExcel/Shared/trend/trendClass.php',
);
