#ifndef MAINWINDOW_H
#define MAINWINDOW_H

//#include <QMainWindow>
//#include<QtWidgets>
//#include<QWidget>
//#include <QtNetwork/QNetworkAccessManager>
//#include <QtNetwork/QNetworkRequest>
//#include<QtNetwork/QNetworkReply>

#include "widget.h"

class MainWindow : public QWidget
{
    Q_OBJECT

public:
    MainWindow(QWidget *parent = 0);
    ~MainWindow(){}
    QLineEdit* searchLine;
    QListWidget* searchResults;
    QVector<QString> searchResultsCopy;
    QNetworkAccessManager* manager;
    QNetworkReply* reply;
    QNetworkRequest request;
    QString resPrev;

    Widget window;

    bool Contains(QString res);
    void SetList();
    void StringParser(QString);

public slots:
    void ResultChanged(QString res);
    void replyFinished();
    void ChangeWindow(QListWidgetItem*);
    void Show();


};

#endif // MAINWINDOW_H
