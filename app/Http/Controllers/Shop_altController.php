<?php

namespace App\Http\Controllers;

use App\Genre;
use App\Record;
use Illuminate\Http\Request;
use Json;

class Shop_altController extends Controller
{
    // Master Page: http://vinyl_shop.test/shop_alt or http://localhost:3000/shop_alt
    public function index(\Request $request)
    {
        $genres = Genre::has('records')->orderBy('name')->get()->transform(function($item, $key){
            $item->name = ucfirst($item->name);
            unset($item->created_at, $item->updated_at, $item->records_count);
            return $item;
        });

        $records = Record::orderBy('artist')->get();
        $result = compact('genres', 'records');
        \Json::dump($result);
        return view('shop_alt.index', ['genres' => $genres, 'records' => $records]);
    }

    // Detail Page: http://vinyl_shop.test/shop_alt/{id} or http://localhost:3000/shop_alt/{id}
    public function show($id)
    {
        //Shop: detail page
        $record = Record::with('genre')->findOrFail($id);
        // dd($record);
        // Real path to cover image
        $record->cover = $record->cover ?? "https://coverartarchive.org/release/$record->title_mbid/front-250.jpg";
        // Combine artist + title
        $record->title = $record->artist . ' - ' . $record->title;
        // Links to MusicBrainz API (used by jQuery)
        // https://wiki.musicbrainz.org/Development/JSON_Web_Service
        $record->artistUrl = 'https://musicbrainz.org/ws/2/artist/' . $record->artist_mbid . '?inc=url-rels&fmt=json';
        $record->recordUrl = 'https://musicbrainz.org/ws/2/release/' . $record->title_mbid . '?inc=recordings+url-rels&fmt=json';
        // If stock > 0: button is green, otherwise the button is red
        $record->btnClass = $record->stock > 0 ? 'btn-outline-success' : 'btn-outline-danger';
        // You can't overwrite the attribute genre (object) with a string, so we make a new attribute
        $record->genreName = $record->genre->name;
        // Remove attributes you don't need for the view
        unset($record->genre_id, $record->artist, $record->created_at, $record->updated_at, $record->artist_mbid, $record->title_mbid, $record->genre);
        $result = compact('record');
        Json::dump($result);
        return view('shop.show', $result);  // Pass $result to the view
    }
}
