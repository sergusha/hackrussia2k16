#ifndef WIDGET_H
#define WIDGET_H

#include "rightwidget.h"
#include <QVector>
struct Department{
    int id;
    QString name;
    int totalNumber;
    int bookedNumber;
    int busyNumber;
    int freeNumber;
};

class Widget : public QWidget
{
    Q_OBJECT

public:
    Widget(QWidget *parent = 0);
    ~Widget();
    void parseScrubsInfo(QString reply);
    void getDepartmentInfo();
    void parseDepartmentInfo(QString reply);
    void getDepartmentNames();
    void setHospitalName(QString);
public slots:
    void show_content(QListWidgetItem*);
    void replyOnDepartmentNames();
    void replyOnGetInfo();
  //  void goBackSlot();

/*signals:
    void Hide();
*/
private:
    QHBoxLayout *main_layout;
//    QVector<QPushButton *> buttons;
    RightWidget *rightWidget;

    QNetworkAccessManager *manager;
    QNetworkReply *reply;
    QNetworkRequest request;

    QVector<Department> departments;

    QString hospitalName;

    QListWidget *listWidget;
  //  QPushButton* goBack;

    int SCRUBS_ID;
    bool getDone;
};

#endif // WIDGET_H
