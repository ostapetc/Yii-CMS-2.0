<ul class="sub_menu">
     <?
     for ($i = 0, $count = count($items); $i < $count; $i++)
     {
         $item = $items[$i];
         $class = '';
         if ($i == 0)
         {
             $class = 'first';
         }
         if ($i == $count - 1)
         {
             $class = 'last ';
         }
         ?>

         <li class="<? echo $class ?>">
             <a href="<? echo $item->href ?>"><? echo $item->title; ?></a>
         </li>
     <? } ?>
</ul>