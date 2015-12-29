
Imports System.Net

Public Class BaseController
    Public Function GetApiDataByUriJson(endpoints As Uri) As String
        Dim client As WebClient
        Dim jsonres As String

        client = New WebClient()
        jsonres = client.DownloadString(endpoints)

        client.Dispose()

        Return jsonres
    End Function
End Class
