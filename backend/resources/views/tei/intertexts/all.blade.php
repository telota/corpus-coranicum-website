<?xml version="1.0" encoding="UTF-8"?>
<?xml-model href="../schema/corpus_coranicum.rng" type="application/xml" schematypens="http://relaxng.org/ns/structure/1.0"?>
<?xml-model href="../schema/corpus_coranicum.rng" type="application/xml" schematypens="http://purl.oclc.org/dsdl/schematron"?>
<TEI xmlns="http://www.tei-c.org/ns/1.0" xml:id="tuk_doi">
   <!--add the DOI here!-->
   <teiHeader>
      <fileDesc>
         <titleStmt>
            <title>{{ $data['title'] }}</title>
            <title/>
            <funder>Corpus Coranicum (BBAW)</funder>
            @include('tei.templates.respStmt')
         </titleStmt>
         @include('tei.templates.publisher')
         <sourceDesc>
            <msDesc xml:id="tuk_{{$data['id']}}" xml:lang="en">
               <msIdentifier>
                  <repository>Corpus Coranicum</repository>
                  <idno>{{$data['id']}}</idno>
               </msIdentifier>
               <msContents>
                  <summary>{{$data['annotations']}}</summary>
                  <msItem>
                     <title>{{ $data['title'] }}</title>
                     <author>{{ $data['author'] }}</author>
                     <textLang mainLang="{{ $data['language-iso-639-3'] }}">{{ $data['language'] }}</textLang>
                  </msItem>
               </msContents>
               <physDesc> </physDesc>
               <history>
                  <origin>
                     <origDate calendar="gregorian">{{ $data['date'] }}</origDate>
                     <origPlace>{{ $data['location'] }}</origPlace>
                  </origin>
               </history>
               <additional>
                  <adminInfo>
                  <recordHist>
                      <source><p>The editors and contributions to Corpus Coranicum.</p></source>
                     </recordHist>
                  </adminInfo>
                  <listBibl>
                     <bibl type="edition">{{ $data['edition'] }}</bibl>
                     @foreach ($data['literature_formatted'] as $literatur)
                        <bibl type="literatur">{{$literatur}}</bibl> {{-- <!--ZOTERO ID wenn verfügbar ergänzen--> --}}
                     @endforeach                     
                  </listBibl>
               </additional>
            </msDesc>
         </sourceDesc>
      </fileDesc>
   @include('tei.templates.encoding', ['type'=>'intertext'])
   </teiHeader>
   @if(sizeof($data['images'])> 0)
      <facsimile>
         <surface>
               @foreach($data['images'] as $image)
                  <graphic url="{{config('cc_config.digilib.base') . $image['bildlink'] . config('cc_config.digilib.width_parameter')}}" />
               @endforeach
         </surface>
      </facsimile>
   @endif
   <text>
      <body>
         <div type="transcription" xml:lang="{{ $data['language-iso-639-3'] }}"><p>{{ $data['language_original'] }}</p></div>
         <div type="translation"  xml:lang="deu"><p>{{ $data['translation']['de'] }}</p></div>
         <div type="translation"  xml:lang="eng"><p>{{ $data['translation']['en'] }}</p></div>
      </body>
   </text>
</TEI>
