<?php
// app/Controllers/ContactController.php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RedirectResponse;

class ContactController extends Controller
{
    // ── Formular anzeigen ─────────────────────────────────────────────────
    public function index(): string
    {
        helper('form'); 
        return view('contact/form');
    }

    // ── Formular verarbeiten ──────────────────────────────────────────────
    public function send(): RedirectResponse|string
    {
        helper('form');
        // ① Methoden-Check: Nur POST erlaubt (zusätzliche Absicherung)
        if (! $this->request->is('post')) {
            return $this->response->setStatusCode(405)->setBody('Method Not Allowed');
        }

        // ② Validierungsregeln definieren
        //    Alle Regeln werden serverseitig geprüft – clientseitige Validierung
        //    (HTML5 required, type="email") ist nur UI-Komfort, kein Schutz!
        $rules = [
            'name' => [
                'label' => 'Name',
                'rules' => 'required|min_length[2]|max_length[100]'
                         . '|alpha_space',
                // alpha_space: nur Buchstaben & Leerzeichen → verhindert
                // HTML-/Script-Injections im Namen
            ],
            'email' => [
                'label' => 'E-Mail-Adresse',
                'rules' => 'required|valid_email|max_length[254]',
                // max_length[254]: RFC 5321-Limit für E-Mail-Adressen
            ],
            'betreff' => [
                'label' => 'Betreff',
                'rules' => 'required|min_length[3]|max_length[150]',
            ],
            'nachricht' => [
                'label' => 'Nachricht',
                'rules' => 'required|min_length[10]|max_length[3000]',
            ],
        ];

        // ③ Validierung ausführen
        if (! $this->validate($rules)) {
            // Fehler werden mit session()->getFlashdata('errors') im View ausgegeben
            return view('contact/form', [
                'validation' => $this->validator,
                // Eingaben zurückgeben, damit der Nutzer nicht alles neu tippt
                'old'        => $this->request->getPost(),
            ]);
        }

        // ④ Validierte Daten sauber auslesen
        //    getPost() ohne Parameter gibt NUR die Felder zurück, die explizit
        //    abgefragt werden → kein "Mass Assignment" aus dem Request möglich
        $name      = $this->request->getPost('name');
        $email     = $this->request->getPost('email');
        $betreff   = $this->request->getPost('betreff');
        $nachricht = $this->request->getPost('nachricht');

        // ⑤ Ausgabe escapen (XSS-Schutz)
        //    esc() wandelt <, >, &, " und ' in HTML-Entities um
        //    → verhindert, dass Schadcode im E-Mail-HTML ausgeführt wird
        $nameSafe      = esc($name);
        $nachrichtSafe = esc($nachricht);
        $betreffSafe   = esc($betreff);

        // ⑥ E-Mail aufbauen und versenden
        $emailService = \Config\Services::email();

        $emailService->setFrom(
            env('EMAIL_FROM_ADDR'),  // Absender-Adresse (aus .env)
            env('EMAIL_FROM_NAME')   // Absender-Name
        );

        // Empfänger: feste interne Adresse – NIEMALS den User-Input als Empfänger!
        $emailService->setTo('kabel@vertriebssoftware24.de');

        // Reply-To: Nutzer-E-Mail, damit man direkt antworten kann
        $emailService->setReplyTo($email, $nameSafe);

        $emailService->setSubject('[Kontaktformular] ' . $betreffSafe);

        // HTML-Body mit escapen Werten
        $body = "
            <h2>Neue Kontaktanfrage</h2>
            <p><strong>Name:</strong> {$nameSafe}</p>
            <p><strong>E-Mail:</strong> {$email}</p>
            <p><strong>Betreff:</strong> {$betreffSafe}</p>
            <hr>
            <p>{$nachrichtSafe}</p>
        ";

    
        $emailService->setMessage($body);

        // ⑦ Versenden – Fehler abfangen
        if (! $emailService->send()) {
            // Debug-Infos NIEMALS dem Nutzer zeigen (enthält SMTP-Details)

            // Temporär: Fehler in Datei schreiben statt anzeigen
            $debug = $emailService->printDebugger(['headers', 'body', 'subject']);


            log_message('error', $emailService->printDebugger(['headers']));

            return view('contact/form', [
                'error'      => 'Die E-Mail konnte leider nicht versendet werden. '
                              . 'Bitte versuchen Sie es später erneut.',
                'validation' => $this->validator,
                'old'        => $this->request->getPost(),
            ]);
        }

        // ⑧ Nach erfolgreichem Versand weiterleiten (Post-Redirect-Get-Pattern)
        //    Verhindert doppeltes Absenden beim Neuladen der Seite
        return redirect()->to('/kontakt/danke')->with('success', 'Ihre Nachricht wurde gesendet.');
    } 

        public function success()
    {
        return view('contact/success');
    }
} 


